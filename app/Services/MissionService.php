<?php

namespace App\Services;

use App\Repositories\MissionRepository;
use App\Services\Concerns\BaseService;
use Illuminate\Http\Request;

class MissionService extends BaseService
{
    /**
     * @param \App\Repositories\MissionRepository $repository
     */
    public function __construct(MissionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function search($conditions = [])
    {
        $this->makeBuilder($conditions);

        return $this->endFilter();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(Request $request)
    {
        $data = $request->only(['name', 'description']);

        $data['status']     = INACTIVE_MISSION;
        $data['creator_id'] = $request->user()->id;

        return $this->repository->create($data);
    }
}
