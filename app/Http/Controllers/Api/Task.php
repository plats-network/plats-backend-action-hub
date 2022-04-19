<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\EndTaskRequest;
use App\Http\Requests\StartTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskUserResource;
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
        return TaskResource::collection($this->taskService->search($request->toArray()));
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function detail($id)
    {
        return new TaskResource($this->taskService->find($id, ['locations']));
    }

    /**
     * @param \App\Http\Requests\CreateTaskRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(CreateTaskRequest $request)
    {
        return new TaskResource($this->taskService->create($request));
    }

    /**
     * User execute task with location
     *
     * @param \App\Http\Requests\StartTaskRequest $request
     * @param string $taskId
     * @param string $locationId
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function startTask(StartTaskRequest $request, $taskId, $locationId)
    {
        return new TaskUserResource($this->taskService->startTask($taskId, $locationId, $request->user()->id));
    }

    /**
     * @param \App\Http\Requests\EndTaskRequest $request
     * @param string $taskId
     * @param string $locationId
     *
     * @return \App\Http\Resources\TaskUserResource
     */
    public function endLocationTask(EndTaskRequest $request, $taskId, $locationId)
    {
        return new TaskUserResource(
            $this->taskService
                ->endLocation(
                    $taskId,
                    $locationId,
                    $request->user()->id,
                    $request->image
                )
        );
    }
}
