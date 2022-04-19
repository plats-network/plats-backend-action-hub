<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use App\Repositories\TaskUserRepository;
use App\Services\Concerns\BaseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskService extends BaseService
{
    /**
     * @var \App\Repositories\TaskUserRepository
     */
    protected $taskUserRepository;

    /**
     * @param \App\Repositories\TaskRepository $repository
     * @param \App\Repositories\TaskUserRepository $taskUserRepository
     */
    public function __construct(TaskRepository $repository, TaskUserRepository $taskUserRepository)
    {
        $this->repository = $repository;
        $this->taskUserRepository = $taskUserRepository;
    }

    /**
     * @param string $taskId
     * @param string $userId
     */
    public function myLocations($taskId, $userId)
    {
        return $this->taskUserRepository->locations($taskId, $userId);
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
        $this->repository->taskHasLocation($taskId, $locaId);

        abort_if(
            !is_null($this->taskUserRepository->location($userId, $locaId)),
            422,
            trans('task_user.already_started')
        );

        return $this->taskUserRepository->create([
            'user_id' => $userId,
            'task_id' => $taskId,
            'location_id' => $locaId,
            'started_at' => Carbon::now(),
            'ended_at' => null,
        ]);
    }

    /**
     * User has arrived at the location and checked in to complete the task
     *
     * @param string $taskId Task ID
     * @param string $locaId Location ID
     * @param string $userId User ID
     * @param \Illuminate\Http\File|\Illuminate\Http\UploadedFile|string $imageFile
     *
     */
    public function endLocation($taskId, $locaId, $userId, $imageFile)
    {
        // Get and check exists Task and Location
        $this->repository->taskHasLocation($taskId, $locaId);

        $taskUser = $this->taskUserRepository->location($userId, $locaId);
        abort_if(is_null($taskUser), 422, trans('task_user.not_started'));
        abort_if(!is_null($taskUser->ended_at), 422, trans('task_user.update_reject'));

        //Save image
        $filePath = 'user_tasks/' . $userId . '/' . $taskId . '/';
        $image = Storage::putFileAs($filePath, $imageFile, $imageFile->hashName());

        $taskUser->ended_at = Carbon::now();
        $taskUser->save();

        $taskUser->libraries()->create([
            'url' => $image
        ]);

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

        return $this->repository->create($data);
    }

    //protected function
}
