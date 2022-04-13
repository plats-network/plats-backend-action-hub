<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Concerns\BaseRepository;

class TaskRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Task::class;
    }
}
