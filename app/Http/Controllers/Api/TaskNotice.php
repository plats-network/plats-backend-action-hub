<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Repositories\TaskUserRepository;
use App\Http\Resources\NoticeResource;

class TaskNotice extends ApiController
{
    /**
     * @param App\Repositories\TaskUserRepository $taskUserRepository
     */
    public function __construct(
        private TaskUserRepository $taskUserRepository
    ) {
        $this->middleware(
            'auth:api', [
                'except' => [
                    'task_notices',
                ],
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = $this->taskUserRepository
                ->getTaskStatus(USER_PROCESSING_TASK, true)
                ->get();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Data not found!');
        }

        return $this->respondWithResource(NoticeResource::collection($data));
    }
}
