<?php

namespace App\Http\Controllers\ActionHub;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;

class Task extends Controller
{
    /**
     * @var \App\Services\TaskService
     */
    protected $taskService;

    /**
     * @param \App\Services\TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @param \App\Http\Requests\CreateTaskRequest $request
     * @param $missionId
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(CreateTaskRequest $request, $missionId)
    {
        return new TaskResource($this->taskService->create($request, $missionId));
    }
}
