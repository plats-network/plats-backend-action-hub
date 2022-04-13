<?php

namespace App\Http\Controllers\ActionHub;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\Request;

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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return TaskResource::collection($this->taskService->search(['creator_id' => $request->user()->id]));
    }

    /**
     * @param string $id
     */
    public function detail($id)
    {
        return new TaskResource($this->taskService->find($id, ['locations']));
    }

    /**
     * @param \App\Http\Requests\CreateTaskRequest $request
     *
     * @return \App\Http\Resources\TaskResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(CreateTaskRequest $request)
    {
        return new TaskResource($this->taskService->create($request));
    }
}
