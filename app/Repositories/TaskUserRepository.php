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
     * @param string $userId
     * @param string $locaId
     *
     * @return mixed
     */
    public function location($userId, $locaId)
    {
        return $this->model->where('user_id', $userId)->where('location_id', $locaId)->first();
    }
}
