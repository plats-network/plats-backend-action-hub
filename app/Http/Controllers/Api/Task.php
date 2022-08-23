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

class Task extends ApiController
{
    /**
     * @var \App\Services\TaskService
     */
    protected $taskService;

    /**
     * @param \App\Services\TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $taskList = TaskResource::collection($this->taskService->getTaskList($userId, $request->get('page'), $request->get('limit')));
        
        return $this->respondWithResource($taskList);
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function detail(Request $request, $id)
    {
        $task = $this->taskService->mapUserHistory($id, $request->user()->id);
        
        //$task->remaining = $this->taskService->timeRemaining($task->histories, $task->duration);
        if(!$task) {
            return $this->respondError('Task not found');
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
