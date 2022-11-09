<?php

namespace App\Services;

use App\Events\UserCanceledTaskEvent;
use App\Events\UserCheckedInLocationEvent;
use App\Events\UserCheckingLocationEvent;
use App\Repositories\LocationHistoryRepository;
use App\Repositories\TaskRepository;
use App\Repositories\TaskUserRepository;
use App\Services\Concerns\BaseService;
use App\Services\Traits\TaskLocationTrait;
use App\Models\TaskLocationHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TaskService extends BaseService
{
    use TaskLocationTrait;

    /**
     * @var \App\Repositories\LocationHistoryRepository
     */
    protected $locationHistoryRepository;

    /**
     * @var \App\Repositories\TaskUserRepository
     */
    protected $taskUserRepository;

    /**
     * @param \App\Repositories\TaskRepository $repository
     * @param \App\Repositories\LocationHistoryRepository $locationHistoryRepository
     * @param \App\Repositories\TaskUserRepository $taskUserRepository
     */
    public function __construct(
        TaskRepository $repository,
        LocationHistoryRepository $locationHistoryRepository,
        TaskUserRepository $taskUserRepository
    ) {
        $this->repository = $repository;
        $this->locationHistoryRepository = $locationHistoryRepository;
        $this->taskUserRepository = $taskUserRepository;
    }

    /**
     * Get list of task on home page, relationship to user status with task
     *
     * @param string $userId
     */
    public function getTaskList($userId, $page = 1, $limit = PAGE_SIZE)
    {
        $tasks = $this->repository->latestTasks($limit);

        //Load relationship
        $tasks = $tasks->load(['participants' => function ($query) use ($userId) {
            return $query->where('user_id', $userId);
        }]);

        return new Paginator($tasks, $limit, $page);
    }
    /**
     * Get task you are doing
     *
     * @param string $userId
     */
    public function getTaskDoing($userId)
    {
        $task = $this->taskUserRepository->userDoingTask($userId);

        return $task;
    }

    /**
     * Auto paginate with query parameters
     *
     * @param  array  $conditions
     *
     * @return mixed
     */
    public function search($conditions = [])
    {
        $this->makeBuilder($conditions);

        if (isset($conditions['withCount'])) {
            foreach ($conditions['withCount'] as $relation) {
                $this->builder = $this->builder->withCount($relation);
            }

            $this->cleanFilterBuilder('withCount');
        }

        return $this->endFilter();
    }

    /**
     * Calculate the remaining time of the quest from the start
     *
     * @param \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection $userHistories
     * @param integer $duration Minute
     */
    public function timeRemaining($userHistories, $duration)
    {
        return $duration;
        //TODO: Calculate
        $timeUsed = 0;
        foreach ($userHistories as $history) {
            if (is_null($history->ended_at)) {
                continue;
            }
            $calcu = Carbon::parse($history->started_at)->diffInRealMinutes(Carbon::parse($history->ended_at));
            $timeUsed += 0;
        }

        return $duration - $timeUsed;
    }

    /**
     * User start task at location
     *
     * @param string $taskId Task ID
     * @param string $locaId Location ID
     * @param string $userId User ID
     * @param string $walletAddress
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function startTask($taskId, $locaId, $userId, $postData)
    {
        $task = $this->repository->whereId($taskId)->get();
        // Get and check exists Task and Location
        $taskHasLocal = $this->repository->taskHasLocation($taskId, $locaId);
        $userDoingOtherTasks = $this->taskUserRepository->userDoingOtherTasks($taskId, $userId);
        $userStartedTask = $this->taskUserRepository->userStartedTask($taskId, $userId, $locaId);
        $errors = [];
        if ($userDoingOtherTasks || $userStartedTask) {
            $errors ['userDoingOtherTasks'] =  $userDoingOtherTasks;
            $errors ['userStartedTask'] =  $userStartedTask;

            return $errors;
        }
        DB::beginTransaction();
        try {
            $locaUserHistory = $this->locationHistoryRepository->create([
                'user_id' => $userId,
                'location_id' => $locaId,
                'started_at' => SupportCarbon::now(),
                'ended_at' => null,
            ]);
            //This is the user's first location
            if (is_null($this->taskUserRepository->userStartedTask($taskId, $userId, $locaId))) {
                $this->taskUserRepository->create([
                    'user_id'                   => $userId,
                    'task_id'                   => $taskId,
                    'status'                    => USER_PROCESSING_TASK,
                    'location_checked'          => $postData['location_checked'] ??  null,
                    'wallet_address'            => $postData['wallet_address'],
                    'time_left'                 => SupportCarbon::now()->addMinutes($taskHasLocal->duration),
                ]);
            }

            UserCheckingLocationEvent::dispatch($locaUserHistory, $taskHasLocal, $taskId, $userId);
            DB::commit();
        } catch (RuntimeException $exception) {
            DB::rollBack();
            throw $exception;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new RuntimeException($exception->getMessage(), 500062, $exception->getMessage(), $exception);
        }

        return $locaUserHistory;
    }

    /**
     * User has arrived at the location and checked in to complete the task
     *
     * @param string $taskId Task ID
     * @param string $locaId Location ID
     * @param string $userId User ID
     * @param \Illuminate\Http\File|\Illuminate\Http\UploadedFile|string $imageFile
     * @param string $activityLog
     *
     */
    public function checkIn($taskId, $locaId, $userId, $imageFile, $activityLog = null)
    {
        // Get and check exists Task and Location
        $localTask = $this->repository->taskHasLocation($taskId, $locaId);

        if (!$localTask) {
            return null;
        }

        $history = $this->locationHistoryRepository
            ->firstOrNewHistory($userId, $taskId, $locaId);

        //Save image
        $filePath = 'user_tasks/' . $userId . '/' . $taskId;
        $image = Storage::disk('s3')->putFileAs($filePath, $imageFile, $imageFile->hashName());

        $history->ended_at = Carbon::now();
        $history->checkin_image = $image;
        $history->activity_log = $activityLog;
        $history->save();

        // Update taskUser
        $this->taskUserRepository
            ->updateStatusTask($taskId, $userId, USER_COMPLETED_TASK);

        return $history;
    }

    /**
     * Create or Update the task
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed|void
     * @throws \Prettus\Validator\Exceptions\ValidatorException|\Prettus\Repository\Exceptions\RepositoryException
     */
    public function store(Request $request)
    {
        if (!$request->filled('id')) {
            return $this->create($request);
        }

        return $this->update($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(Request $request)
    {
        $data = $request->except(['image', 'guilds']);

        $data['status']     = $request->status;
        $data['type']       = $request->type;
        $data['creator_id'] = $request->user()->id;

        //Save cover
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            $path = 'tasks/cover/' . Carbon::now()->format('Ymd');
            $data['image'] = Storage::disk('s3')->putFileAs($path, $uploadedFile, $uploadedFile->hashName());
        }

        $task = $this->repository->create($data);

        //Create location
        $this->createLocation($task, $request->input('locations'));

        //Create rewards
        // $this->createRewards($task, $request->input('rewards'));

        $this->withSuccess(trans('admin.task_created'));

        return $task;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function update(Request $request)
    {
        $task = $this->find($request->input('id'));

        $data = $request->except(['image', 'locations', 'guilds']);

        //Save cover
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            $path = 'tasks/cover/' . Carbon::now()->format('Ymd');
            $data['image'] = Storage::disk('s3')->putFileAs($path, $uploadedFile, $uploadedFile->hashName());
        }

        $task = $this->repository->updateByModel($task, $data);

        //Update/Create Location
        if ($request->filled('locations')) {
            $createLocations = [];
            $updateLocations = [];
            foreach ($request->input('locations', []) as $location) {
                if (isset($location['id']) && !empty($location['id'])) {
                    $updateLocations[] = $location;
                    continue;
                }

                $createLocations[] = $location;
            }

            //Create location
            $this->createLocation($task, $createLocations);
            $this->updateLocation($task, $updateLocations);
        }

        //Delete location
        if ($request->filled('location_delete')) {
            $task->locations()
                ->whereIn('id', $request->input('location_delete', []))
                ->delete();
        }

        return $task;
    }

    /**
     * @param string $taskId
     * @param string $userId
     *
     * @return mixed|void
     */
    public function mapUserHistory($taskId, $userId)
    {
        $taskData = $this->find($taskId, ['locations.guides', 'galleries']);
        if(!$taskData) {
            return $taskData;
        }
        $task = $taskData->load([
                'participants' => function ($q) use ($userId) {
                    return $q->where('user_id', $userId);
                },
            ]);

        /**
         * Get user histories with task and map user_status to each location
         */
        $userHistories = $this->locationHistoryRepository
            ->myHistoryInLocas($userId, $task->locations->pluck('id'));

        if ($userHistories->isEmpty()) {
            return $task;
        }

        $task->locations = $task->locations->map(function ($location) use ($userHistories) {
            $userTask = $userHistories
                ->where('location_id', $location->id)
                ->first();

            if (is_null($userTask)) {
                return $location->user_status = USER_WAITING_TASK;
            }

            if (is_null($userTask->ended_at)) {
                return $location->user_status = USER_PROCESSING_TASK;
            }

            $location->user_status = USER_COMPLETED_TASK;
            $location->activity_log = $userTask->activity_log;

            return $location;
        });

        return $task;
    }

    /**
     * @param string $userId
     * @param string $taskId
     */
    public function cancel($userId, $taskId, $locaId)
    {
        $task = $this->find($taskId, ['locations']);

        $userTask = $this->taskUserRepository
            ->userStartedTask($taskId, $userId, $locaId);

        if (is_null($userTask)) {
            return null;
        }
        // abort_if(is_null($userTask), 404);

        $userTask->delete();

        $this->locationHistoryRepository
            ->getModel()
            ->ofUser($userId)
            ->whereIn('location_id', $task->locations->pluck('id'))
            ->delete();

        UserCanceledTaskEvent::dispatch($userId, $taskId);

        return true;
    }
}
