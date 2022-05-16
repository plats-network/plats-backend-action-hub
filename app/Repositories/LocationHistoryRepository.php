<?php

namespace App\Repositories;

use App\Models\TaskLocationHistory;
use App\Repositories\Concerns\BaseRepository;

class LocationHistoryRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TaskLocationHistory::class;
    }

    /**
     * @param string $userId
     * @param string $locaId
     *
     * @return mixed
     */
    public function location($userId, $locaId)
    {
        return $this->model->ofUser($userId)->where('location_id', $locaId)->first();
    }

    /**
     * Get check-in histories of user by task
     *
     * @param string $taskId
     * @param string $userId
     *
     * @return mixed
     */
/*    public function locations($taskId, $userId)
    {
        return $this->model->ofUser($userId)->where('task_id', $taskId)->get();
    }*/

    /**
     * @param string $userId
     * @param string | array[string, string] $locas list id of location
     */
    public function myHistoryInLocas($userId, $locas)
    {
        $builder = $this->model->ofUser($userId);

        if (is_string($locas)) {
            return $builder->where('location_id', $locas)->get();
        }

        return $builder->whereIn('location_id', $locas)->get();
    }
}
