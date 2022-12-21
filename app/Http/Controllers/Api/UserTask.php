<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\UserTaskHistoryResource;
use App\Services\UserTaskService;
use Illuminate\Http\Request;

class UserTask extends ApiController
{
    /**
     * @var \App\Services\UserTaskService
     */
    protected $userTaskService;

    /**
     * @param \App\Services\UserTaskService $userTaskService
     */
    public function __construct(UserTaskService $userTaskService)
    {
        $this->userTaskService = $userTaskService;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function histories(Request $request)
    {
        return UserTaskHistoryResource::collection($this->userTaskService->search(['user_id' => $request->user()->id]));
    }
}
