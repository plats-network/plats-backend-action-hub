<?php

namespace App\Services;

use App\Events\UserCheckedInLocationEvent;
use App\Events\UserCheckingLocationEvent;
use App\Repositories\LocationHistoryRepository;
use App\Repositories\TaskRepository;
use App\Repositories\TaskUserRepository;
use App\Services\Concerns\BaseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class TaskService extends BaseService
{
    /**
     * @var \App\Repositories\LocationHistoryRepository
     */
    protected $localHistoryRepo;

    /**
     * @var \App\Repositories\TaskUserRepository
     */
    protected $taskUserRepository;

    /**
     * @param \App\Repositories\TaskRepository $repository
     * @param \App\Repositories\LocationHistoryRepository $localHistoryRepo
     * @param \App\Repositories\TaskUserRepository $taskUserRepository
     */
    public function __construct(
        TaskRepository $repository,
        LocationHistoryRepository $localHistoryRepo,
        TaskUserRepository $taskUserRepository
    ) {
        $this->repository       = $repository;
        $this->localHistoryRepo = $localHistoryRepo;
        $this->taskUserRepository = $taskUserRepository;
    }

    /**
     * Get list of task on home page, relationship to user status with task
     *
     * @param string $userId
     */
    public function home($userId, $page = 1, $limit = PAGE_SIZE)
    {
        $tasks = $this->repository->latestTasks($limit);

        //Load relationship
        $tasks = $tasks->load(['participants' => function ($q) use ($userId) {
            return $q->where('user_id', $userId);
        }]);

        return new Paginator($tasks, $limit, $page);
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
            dd($calcu);
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
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function startTask($taskId, $locaId, $userId)
    {
        // Get and check exists Task and Location
        $taskHasLocal = $this->repository->taskHasLocation($taskId, $locaId);

        abort_if(
            !is_null($this->localHistoryRepo->location($userId, $locaId)),
            422,
            trans('task_user.already_started')
        );

        $locaUserHistory = $this->localHistoryRepo->create([
            'user_id' => $userId,
            'location_id' => $locaId,
            'started_at' => Carbon::now(),
            'ended_at' => null,
        ]);

        //This is the user's first location
        if (is_null($this->taskUserRepository->userStartedTask($taskId, $userId))) {
            $this->taskUserRepository->create([
                'user_id'   => $userId,
                'task_id'   => $taskId,
                'status'    => USER_PROCESSING_TASK,
                'time_left' => $taskHasLocal->duration,
            ]);
        }

        UserCheckingLocationEvent::dispatch($locaUserHistory, $taskHasLocal, $taskId, $userId);

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

        $taskUser = $this->localHistoryRepo->location($userId, $locaId);
        abort_if(is_null($taskUser), 422, trans('task_user.not_started'));
        abort_if(!is_null($taskUser->ended_at), 422, trans('task_user.update_reject'));

        //Save image
        $filePath = 'user_tasks/' . $userId . '/' . $taskId . '/';
        $image = Storage::putFileAs($filePath, $imageFile, $imageFile->hashName());

        $taskUser->ended_at = Carbon::now();
        $taskUser->checkin_image = $image;
        $taskUser->activity_log = $activityLog;
        $taskUser->save();

        //Fire Event
        UserCheckedInLocationEvent::dispatch($taskUser, $localTask, $taskId);

        return $taskUser;
    }

    /**
     * Create or Update the task
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed|void
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(Request $request)
    {
        if (!$request->filled('id')) {
            return $this->create($request);
        }

        dd('Updating...');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(Request $request)
    {
        $data = $request->except(['image']);

        $data['status']     = ACTIVE_TASK;
        $data['type']       = TYPE_FREE_TASK;
        $data['creator_id'] = $request->user()->id;

        //Save cover
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            $path = 'tasks/cover/' . Carbon::now()->format('Ymd');
            $data['image'] = Storage::putFileAs($path, $uploadedFile, $uploadedFile->hashName());
        }

        $task = $this->repository->create($data);
        $locationData = [];
        foreach ($request->input('location') as $order => $location) {
            $longAndLat = explode(',', preg_replace('/\s+/', '', $location['coordinate']));
            $locationData[] = [
                'name' => $location['name'],
                'address' => $location['address'],
                'long' => $longAndLat[0],
                'lat' => $longAndLat[1],
                'sort' => $order,
                'status' => ACTIVE_LOCATION_TASK,
            ];
        }

        if (!empty($locationData)) {
            $task->locations()->createMany($locationData);
        }

        $this->withSuccess(trans('admin.task_created'));

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
        $task = $this->find($taskId, ['locations', 'galleries'])->load([
                'participants' => function ($q) use ($userId) {
                    return $q->where('user_id', $userId);
                },
            ]);

        /**
         * Get user histories with task and map user_status to each location
         */
        $userHistories = $this->localHistoryRepo->myHistoryInLocas($userId, $task->locations->pluck('id'));
        if ($userHistories->isEmpty()) {
            return $task;
        }

        $task->locations = $task->locations->map(function ($location) use ($userHistories) {

            $userTask = $userHistories->where('location_id', $location->id)->first();
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
}
