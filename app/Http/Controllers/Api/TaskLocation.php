<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CreateTaskLocationRequest;
use App\Http\Resources\TaskLocationResource;
use App\Services\TaskLocationService;

class TaskLocation extends ApiController
{
    /**
     * @var \App\Services\TaskLocationService
     */
    protected $taskLocationService;

    /**
     * @param \App\Services\TaskLocationService taskLocationService
     */
    public function __construct(TaskLocationService $taskLocationService)
    {
        $this->taskLocationService = $taskLocationService;
    }

    /**
     * @param \App\Http\Requests\CreateTaskLocationRequest $request
     * @param string $taskId
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(CreateTaskLocationRequest $request, $taskId)
    {
        $taskLocation = new TaskLocationResource($this->taskLocationService->create($request, $taskId));
        return $this->respondWithResource($taskLocation);
    }
}
