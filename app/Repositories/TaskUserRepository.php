<?php

namespace App\Repositories;

use App\Models\TaskUser;
use App\Repositories\Concerns\BaseRepository;

class TaskUserRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TaskUser::class;
    }

    /**
     * @param $taskId
     * @param $userId
     *
     * @return null | TaskUser
     */
    public function userStartedTask($taskId, $userId)
    {
        return $this->model->where('task_id', $taskId)->where('user_id', $userId)->first();
    }
    
    /**
     * @param $taskId
     * @param $userId
     *
     * @return null | TaskUser
     */
    public function userDoingOtherTasks($taskId, $userId)
    {
        return $this->model->where('task_id', '!=', $taskId)->where('user_id', $userId)->where('status', USER_PROCESSING_TASK)->first();
    }
    
    /**
     * @param $taskId
     * @param $userId
     *
     * @return null | TaskUser
     */
    public function userDoingTask($userId)
    {
        return $this->model->where('user_id', $userId)->where('status', USER_PROCESSING_TASK)->first();
    }

    /**
     * @param $taskId
     * @param $userId
     * @param int $status
     *
     * @return mixed
     */
    public function updateStatusTask($taskId, $userId, $status = USER_PROCESSING_TASK)
    {
        return $this->model->where('task_id', $taskId)->where('user_id', $userId)->update(['status' => $status]);
    }
}
