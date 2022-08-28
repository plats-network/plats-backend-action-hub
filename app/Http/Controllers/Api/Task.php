<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CheckInTaskRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\StartTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskUserResource;
use App\Services\TaskService;
use Illuminate\Http\Request;
use App\Models\Task as ModelTask;
use Illuminate\Database\QueryException;

class Task extends ApiController
{
    /**
     * @var \App\Services\TaskService
     */
    protected $taskService;

    /**
     * @var App\Models\Task as ModelTask;
     */
    protected $modelTask;

    /**
     * @param \App\Services\TaskService $taskService
     */
    public function __construct(TaskService $taskService, ModelTask $modelTask)
    {
        $this->taskService  = $taskService;
        $this->modelTask    = $modelTask;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        try {
            $limit = $request->get('limit') ?? PAGE_SIZE;
            $tasks = $this->modelTask->load(['participants' => function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                }])
                ->whereStatus(ACTIVE_TASK)
                ->paginate($limit);
            $paginate = [
                'total_page'    => (int)$tasks->lastPage(),
                'per_page'      => (int)$limit,
                'current_page'  => (int)$request->get('page') ?: 1
            ];
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        return $this->respondWithResource(TaskResource::collection($tasks), $paginate);
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function detail(Request $request, $id)
    {
        try {
            $task = $this->taskService->mapUserHistory($id, $request->user()->id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNoContent();
        }

        return $this->respondWithResource(new TaskResource($task));
    }

    /**
     * @param \App\Http\Requests\CreateTaskRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(CreateTaskRequest $request)
    {
        $data = $this->taskService->create($request);
        return $this->respondWithResource(new TaskUserResource($data), 'Create successful task.', 201);
    }

    /**
     * User execute task with location
     *
     * @param \App\Http\Requests\StartTaskRequest $request
     * @param string $taskId
     * @param string $locationId
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function startTask(StartTaskRequest $request, $taskId, $locationId)
    {
        $startTask = $this->taskService->startTask($taskId, $locationId, $request->user()->id, $request->all());
        
        if($startTask['userDoingOtherTasks']) {
            return $this->respondWithResource(new TaskUserResource($startTask['userDoingOtherTasks']), trans('task_user.starting_other_tasks'), 400);
        }
        if($startTask['userStartedTask']) {
            return $this->respondWithResource(new TaskUserResource($startTask['userStartedTask']), trans('task_user.already_started'), 400);
        }

        return $this->respondWithResource(new TaskUserResource($startTask), 'Start doing the task now.');
    }

    /**
     * @param \App\Http\Requests\CheckInTaskRequest $request
     * @param string $taskId
     * @param string $locationId
     *
     * @return \App\Http\Resources\TaskUserResource
     */
    public function checkIn(CheckInTaskRequest $request, $taskId, $locationId)
    {
        $dataCheckIn = $this->taskService->checkIn($taskId, $locationId, $request->user()->id, $request->image, $request->activity_log);
        
        return $this->respondWithResource(new TaskUserResource($dataCheckIn));
    }
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Http\Resources\TaskUserResource
     */
    public function getTaskDoing(Request $request)
    {
        $dataTaskDoing = $this->taskService->getTaskDoing($request->user()->id);
        
        return $this->respondWithResource(new TaskUserResource($dataTaskDoing));
    }

    /**
     * User cancel task
     *
     * @param \Illuminate\Http\Request $request
     * @param $taskId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(Request $request, $taskId)
    {
        $this->taskService->cancel($request->user()->id, $taskId);

        return $this->responseMessage('DONE!');
    }
}
