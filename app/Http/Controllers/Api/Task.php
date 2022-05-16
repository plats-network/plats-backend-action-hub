<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckInTaskRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\StartTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskUserResource;
use App\Services\TaskService;
use Illuminate\Http\Request;

class Task extends ApiController
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
        return TaskResource::collection($this->taskService->home($request->user()->id));
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function detail(Request $request, $id)
    {
        $task = $this->taskService->mapUserHistory($id, $request->user()->id);

        //$task->remaining = $this->taskService->timeRemaining($task->histories, $task->duration);

        return new TaskResource($task);
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
     * @param \App\Http\Requests\CheckInTaskRequest $request
     * @param string $taskId
     * @param string $locationId
     *
     * @return \App\Http\Resources\TaskUserResource
     */
    public function checkIn(CheckInTaskRequest $request, $taskId, $locationId)
    {
        return new TaskUserResource(
            $this->taskService
                ->checkIn(
                    $taskId,
                    $locationId,
                    $request->user()->id,
                    $request->image,
                    $request->activity_log
                )
        );
    }

    /**
     * User cancel task
     *
     * @param \Illuminate\Http\Request $request
     * @param $taskId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(Request $request, $taskId)
    {
        $this->taskService->cancel($request->user()->id, $taskId);

        return $this->responseMessage('DONE!');
    }
}
