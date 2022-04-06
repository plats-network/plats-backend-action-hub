<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use App\Services\Concerns\BaseService;
use Illuminate\Http\Request;

class TaskService extends BaseService
{
    /**
     * @param \App\Repositories\TaskRepository $repository
     */
    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $conditions
     *
     * @return mixed
     */
    public function search($conditions = [])
    {
        $this->makeBuilder($conditions);

        return $this->endFilter();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $missionId
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(Request $request, $missionId)
    {
        $data = $request->only([
            'name',
            'description',
            'reward_amount',
            'exc_time',
            'long',
            'last',
        ]);

        $data['mission_id'] = $missionId;
        $data['creator_id'] = $request->user()->id;
        $data['status']     = ACTIVE_TASK;

        return $this->repository->create($data);
    }
}
