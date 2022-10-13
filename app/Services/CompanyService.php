<?php

namespace App\Services;

use App\Repositories\CompanyRepository;
use App\Services\Concerns\BaseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompanyService extends BaseService
{
    /**
     * @param \App\Repositories\CompanyRepository $companyRepository
     */
    public function __construct(
        private CompanyRepository $companyRepository
    ) {}

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
     * Create or Update the task
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed|void
     * @throws \Prettus\Validator\Exceptions\ValidatorException|\Prettus\Repository\Exceptions\RepositoryException
     */
    public function store($request)
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
        $data['name'] = $request->get('name');
        $data['address'] = $request->get('address');
        $data['phone'] = $request->get('phone');
        // $data['phone'] = $request->user()->id;

        //Save cover
        if ($request->hasFile('logo_path')) {
            $uploadedFile = $request->file('logo_path');
            $path = 'companies/icons/' . Carbon::now()->format('Ymd');
            $data['logo_path'] = Storage::disk('s3')->putFileAs($path, $uploadedFile, $uploadedFile->hashName());
        }

        $company = $this->companyRepository->create($data);

        $this->withSuccess(trans('admin.task_created'));

        return $company;
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

        // $uploadedFile = $request->file('image');
        // $path = 'tasks/cover/' . Carbon::now()->format('Ymd');
        // dd(Storage::disk('s3')->put($path, $uploadedFile, $uploadedFile->hashName()));
        // $data['image'] = Storage::disk('s3')->putFileAs($path, $uploadedFile, $uploadedFile->hashName());
        //Save cover
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            $path = 'tasks/cover/' . Carbon::now()->format('Ymd');
            // dd(Storage::disk('s3')->putFileAs($path, $uploadedFile, $uploadedFile->hashName()));
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
            $task->locations()->whereIn('id', $request->input('location_delete', []))->delete();
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

    /**
     * @param string $userId
     * @param string $taskId
     */
    public function cancel($userId, $taskId)
    {
        $task = $this->find($taskId, ['locations']);

        $userTask = $this->taskUserRepository->userStartedTask($taskId, $userId);

        if (is_null($userTask)) {
            return null;
        }
        // abort_if(is_null($userTask), 404);

        $userTask->delete();

        $this->localHistoryRepo->getModel()
            ->ofUser($userId)
            ->whereIn('location_id', $task->locations->pluck('id'))
            ->delete();

        UserCanceledTaskEvent::dispatch($userId, $taskId);

        return true;
    }
}
