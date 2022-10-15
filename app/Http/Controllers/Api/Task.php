<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CheckInTaskRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\StartTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskUserResource;
use App\Http\Resources\TaskDogingResource;
use App\Services\TaskService;
use Illuminate\Http\Request;
use App\Models\Task as ModelTask;
use App\Models\TaskUser;
use Illuminate\Database\QueryException;
use App\Repositories\LocationHistoryRepository;
use App\Repositories\TaskRepository;
use App\Repositories\TaskUserRepository;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
     * @var App\Repositories\LocationHistoryRepository;
     */
    protected $locationHistoryRepository;

    /**
     * @var App\Repositories\TaskRepository;
     */
    protected $taskRepository;

    /**
     * @var App\Repositories\TaskUserRepository;
     */
    protected $taskUserRepository;

    /**
     * @param \App\Services\TaskService $taskService
     */
    public function __construct(
        TaskService $taskService,
        ModelTask $modelTask,
        LocationHistoryRepository $locationHistoryRepository,
        TaskRepository $taskRepository,
        TaskUserRepository $taskUserRepository
    ) {
        $this->taskService                  = $taskService;
        $this->modelTask                    = $modelTask;
        $this->locationHistoryRepository    = $locationHistoryRepository;
        $this->taskRepository               = $taskRepository;
        $this->taskUserRepository           = $taskUserRepository;
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
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        $datas = TaskResource::collection($tasks);
        $pages = [
            'current_page' => (int)$request->get('page'),
            'last_page' => $tasks->lastPage(),
            'per_page'  => (int)$limit,
            'total' => $tasks->lastPage()
        ];

        return $this->respondWithIndex($datas, $pages);
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function detail(Request $request, $id)
    {
        $userId = $request->user()->id;
        
        try {
            $task = $this->taskService->mapUserHistory($id, $userId);
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
    public function startTask(Request $request, $taskId, $locationId)
    {
        // Todo: Refactor sau khi co time
        $userId = $request->user()->id;
        $token= request()->bearerToken();
        # Check Task
        $task = $this->taskRepository->find($taskId);

        if (empty($task)) {
            return $this->respondNotFound('Task not found!');
        }

        # Check task inprogress
        $taskImprogress = TaskUser::where('user_id', $userId)
            ->where('status', USER_PROCESSING_TASK)
            ->get();

        if (
            null === $request->get('start_task')
            || empty($request->get('start_task'))
        ) {

            if ($taskImprogress->count() > 0) {
                $datas = ['is_improgress' => true];

                return $this->respondWithResource(new TaskUserResource($datas), "Có task đang chạy!");
            } else {
                $this->createTask($taskId, $userId, $locationId, $task, $taskImprogress);

                // Push notice by service
                $this->pushNotice($token, $task->title, $task->description, $taskId);
            }
        } else {
            $this->createTask($taskId, $userId, $locationId, $task, $taskImprogress);

            // Push notice by service
            $this->pushNotice($token, $task->title, $task->description, $taskId);
        }

        $datas = ['is_improgress' => false];
        return $this->respondWithResource(new TaskUserResource($datas), 'Start doing the task now.');
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
        $userId = $request->user()->id;

        $checkTaskComplated = $this->taskUserRepository->userStartedTask($taskId, $userId);

        if ($checkTaskComplated && $checkTaskComplated->status == USER_COMPLETED_TASK) {
            return $this->responseMessage('Task checkin done!');
        }

        $dataCheckIn = $this->taskService
            ->checkIn($taskId, $locationId,$userId, $request->image, $request->activity_log);
        
        return $this->respondWithResource(new TaskUserResource($dataCheckIn));
    }
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Http\Resources\TaskUserResource
     */
    public function getTaskDoing(Request $request)
    {
        $userId = $request->user()->id;

        $dataTaskDoing = $this->taskService->getTaskDoing($userId);

        if (is_null($dataTaskDoing)) {
            return $this->respondNotFound();
        }

        return $this->respondWithResource(new TaskDogingResource($dataTaskDoing));
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
        $userId = $request->user()->id;

        $cancel = $this->taskService->cancel($userId, $taskId);

        if (is_null($cancel)) {
            return $this->respondNotFound();
        }

        return $this->responseMessage('DONE!');
    }

    private function createTask($taskId, $userId, $taskLocationId, $task, $taskImprogress)
    {
        DB::beginTransaction();
        try {
            foreach ($taskImprogress as $taskUser) {
                $taskUser->update(['status' => USER_CANCEL_TASK]);
            }

            $this->locationHistoryRepository->create([
                'user_id' => $userId,
                'location_id' => $taskLocationId,
                'started_at' => SupportCarbon::now(),
                'ended_at' => null
            ]);

            $this->taskUserRepository->create([
                'user_id' => $userId,
                'task_id' => $taskId,
                'status' => USER_PROCESSING_TASK,
                'location_checked' => null,
                'wallet_address' => null,
                'time_left' => SupportCarbon::now()->addMinutes($task->duration),
                'time_start' => SupportCarbon::now(),
                'time_end'  => SupportCarbon::now()->addMinutes($task->duration)
            ]);

            DB::commit();
        } catch (RuntimeException $exception) {
            DB::rollBack();
            throw $exception;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new RuntimeException($exception->getMessage(), 500062, $exception->getMessage(), $exception);
        }
    }

    private function pushNotice($token, $title, $desc, $taskId)
    {
        Http::withToken($token)->post(config('app.api_url_notice') . "/api/push_notice", [
            "title" => $title,
            "description" => $desc,
            "type" => "new_task",
            "task_id" => $taskId,
            "icon"  => null
        ]);

        return;
    }
}
