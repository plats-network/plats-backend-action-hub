<?php

namespace App\Repositories;

use App\Models\Tasks;
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
        return Tasks::class;
    }
}
