<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\{
    CheckInTaskRequest,
    CreateTaskRequest,
    StartTaskRequest,
    UserActionRequest
};
use App\Http\Resources\{TaskResource, TaskUserResource, TaskDogingResource, SocialResource, CheckInResource};
use App\Repositories\{LocationHistoryRepository, TaskRepository, TaskUserRepository};
use App\Services\TaskService;
use Illuminate\Http\Request;
use App\Models\{
    Task as ModelTask,
    UserTaskAction, TaskUser
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\{DB, Http};
use Carbon\Carbon;

class Task extends ApiController
{
    /**
     * @param $taskService
     * @param $modelTask
     * @param $locationHistoryRepository
     * @param $taskRepository
     * @param $taskUserRepository
     * 
     */
    public function __construct(
        private TaskService $taskService,
        private ModelTask $modelTask,
        private TaskUser $taskUser,
        private LocationHistoryRepository $locationHistoryRepository,
        private TaskRepository $taskRepository,
        private TaskUserRepository $taskUserRepository,
        private UserTaskAction $userTaskAction
    ) {}

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        try {
            $userId = $request->user()->id;
            $limit = $request->get('limit') ?? PAGE_SIZE;

            $tasks = $this->modelTask
                ->with(['taskLocations', 'taskSocials'])
                ->whereStatus(ACTIVE_TASK)
                ->where('end_at', '>=', Carbon::now())
                ->orderBy('created_at', 'desc')
                ->paginate($limit);

        } catch (QueryException $e) {
            return $this->respondNotFound();
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
        try {
            $userId = $request->user()->id;
            $task = $this->modelTask->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        return $this->respondWithResource(new TaskResource($task));
    }

    public function taskAction(UserActionRequest $request)
    {
        try {
            $type = $request->input('type');
            $taskId = $request->input('task_id');
            $userId = $request->user()->id;
            $typeNum = ($type == 'like' || $type == 'unlike') ? TASK_LIKE : TASK_PIN;

            $userLikePin = $this->userTaskAction
                ->whereUserId($userId)
                ->whereTaskId($taskId)
                ->whereType($typeNum)
                ->first();

            if ($type == 'like') {
                if (!$userLikePin) {
                    $this->userTaskAction->create([
                        'user_id' => $userId,
                        'task_id' => $taskId,
                        'type' => $typeNum
                    ]);
                }

                $mess = 'Liked';
            }

            if ($type == 'unlike') {
                if ($userLikePin) { $userLikePin->delete(); }
                $mess = 'Unliked';
            }

            if ($type == 'pin') {
                if (!$userLikePin) {
                    $this->userTaskAction->create([
                        'user_id' => $userId,
                        'task_id' => $taskId,
                        'type' => $typeNum
                    ]);
                }

                $mess = 'Pinned';
            }

            if ($type == 'unpin') {
                if ($userLikePin) { $userLikePin->delete(); }
                $mess = 'Unpinned';
            }
        } catch (\Exception $e) {
            return $this->respondNotFound();
        }

        return $this->responseMessage($mess);
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
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function startTask(Request $request)
    {
        try {
            $userId = $request->user()->id;
            $taskId = $request->input('task_id');
            $task = $this->modelTask->findOrFail($taskId);
            $checkStart = $this->taskUser
                ->whereUserId($userId)
                ->whereTaskId($taskId)
                ->whereStatus(0)
                ->first();

            if ($request->input('type') == 'start') {
                if (!$checkStart) {
                    $this->taskUser->create([
                        'user_id' => $userId,
                        'task_id' => $taskId,
                        'status' => 0,
                        'finish_at' => $task->end_at,
                    ]);
                }

                $mess = 'Start done!';
            }

            if ($request->input('type') == 'cancel') {
                if ($checkStart) {
                    $checkStart->update(['status' => 2]);
                }

                $mess = 'Cancel done!';
            }
        } catch (\Exception $e) {
            return $this->respondNotFound();
        }

        return $this->responseMessage($mess);


        // OLD
        $token= request()->bearerToken();
        # Check Task
        $task = $this->taskRepository->find($taskId);

        if (empty($task)) {
            return $this->respondNotFound('Task not found!');
        }

        # Update task time out
        TaskUser::whereHas('task', function($query) {
                $query->where('type', TYPE_CHECKIN);
            })
            ->where('user_id', $userId)
            ->where('status', USER_PROCESSING_TASK)
            ->where('time_end', '<', Carbon::now())
            ->update(['status' => USER_TIMEOUT_TASK]);

        # Check task done
        $doneTask = $this->taskUserRepository->userStartedTask($taskId, $userId, $locationId);
        if ($doneTask
            && $doneTask->status == USER_COMPLETED_TASK
            && $doneTask->location_id == $locationId) {
            return $this->responseMessage('Task checkin done!');
        }

        # Check task inprogress
        $taskImprogress = TaskUser::whereHas('task', function($query) {
                $query->where('type', TYPE_CHECKIN);
            })
            ->whereUserId($userId)
            ->whereStatus(USER_PROCESSING_TASK)
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
            }
        } else {
            $this->createTask($taskId, $userId, $locationId, $task, $taskImprogress);
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

        $checkTaskComplated = $this->taskUserRepository
            ->userStartedTask($taskId, $userId, $locationId);

        if ($checkTaskComplated
            && $checkTaskComplated->status == USER_COMPLETED_TASK) {
            return $this->responseMessage('Task checkin done!');
        }

        $dataCheckIn = $this->taskService
            ->checkIn($taskId, $locationId, $userId, $request->image, $request->activity_log);
        
        return $this->respondWithResource(new CheckInResource($dataCheckIn));
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
        $dataTaskDoing = $this->taskService->getTaskDoing($userId);

        if (!$dataTaskDoing) {
            return $this->respondNotFound();
        }

        $cancel = $this->taskService
            ->cancel($userId, $taskId, $dataTaskDoing->location_id);

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
                'location_id' => $taskLocationId,
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
}
