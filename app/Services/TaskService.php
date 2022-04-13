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
}
