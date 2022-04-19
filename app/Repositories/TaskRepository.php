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

    /**
     * @param $taskId
     * @param $locaId
     *
     * @return mixed
     */
    public function taskHasLocation($taskId, $locaId)
    {
        return $this->model->hasLocation($locaId)->findOrFail($taskId);
    }
}
