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
     * @return mixed
     */
    public function latestTasks($limit = PAGE_SIZE)
    {
        return $this->model->where('status', ACTIVE_TASK)->latest()->limit($limit)->get();
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
