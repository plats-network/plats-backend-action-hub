<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\RewardResource;
use App\Http\Resources\Admin\TaskResource;
use App\Services\Admin\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Tasks extends ApiController
{
    public function __construct(
        private TaskService $taskService
    )
    {
        $this->middleware('client_admin');
    }

    public function index(Request $request)
    {
        $limit = $request->get('limit') ?? PAGE_SIZE;
        if (Auth::user()->role == CLIENT_ROLE) {
            $rewards = $this->taskService->search(['limit' => $limit, 'creator_id' => Auth::user()->id ]);
        } else {
            $rewards = $this->taskService->search( ['limit' => $limit]);
        }
        $datas = TaskResource::collection($rewards);
        $pages = [
            'current_page' => (int)$request->get('page'),
            'last_page' => $rewards->lastPage(),
            'per_page'  => (int)$limit,
            'total' => $rewards->lastPage()
        ];

        return $this->respondWithIndex($datas, $pages);
    }

    public function store(Request $request)
    {
        $reward = $this->taskService->store($request);
        return $this->responseMessage('success');
    }
}
