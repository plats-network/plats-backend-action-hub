<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\RewardResource;
use App\Http\Resources\Admin\TaskResource;
use App\Services\Admin\TaskService;
use Illuminate\Http\Request;

class Tasks extends ApiController
{
    public function __construct(
        private TaskService $taskService
    )
    {

    }

    public function index(Request $request)
    {
        $rewards = $this->taskService->search( ['limit' => $request->get('limit') ?? PAGE_SIZE]);
        return $this->respondWithResource(new TaskResource($rewards));
    }

    public function store(Request $request)
    {
        $reward = $this->taskService->store($request);
        return $this->responseMessage('success');
    }
}
