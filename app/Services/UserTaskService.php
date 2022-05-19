<?php

namespace App\Services;

use App\Repositories\TaskUserRepository;
use App\Services\Concerns\BaseService;

class UserTaskService extends BaseService
{
    /**
     * @param \App\Repositories\TaskUserRepository $repository
     */
    public function __construct(TaskUserRepository $repository)
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
        $this->withLoad = ['task'];

        $this->makeBuilder($conditions);

        return $this->endFilter();
    }
}
