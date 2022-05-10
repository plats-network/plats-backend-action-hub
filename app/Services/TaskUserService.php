<?php

namespace App\Services;

use App\Repositories\TaskUserRepository;
use App\Services\Concerns\BaseService;

class TaskUserService extends BaseService
{
    /**
     * @param \App\Repositories\TaskUserRepository $repository
     */
    public function __construct(TaskUserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Check status of user in tasks
     *
     * @param $userId
     * @param array $listTasks list ids of task
     */
    public function userStatusOfTask($userId, $listTasks)
    {
    }
}
