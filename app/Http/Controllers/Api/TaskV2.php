<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\SocialResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskV2Resource;
use App\Repositories\LocationHistoryRepository;
use App\Repositories\TaskRepository;
use App\Repositories\TaskUserRepository;
use App\Services\TaskService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Task as ModelTask;

class TaskV2 extends ApiController
{
    public function __construct(
        private TaskService $taskService,
        private ModelTask $modelTask,
    ) {}

    public function index(Request $request)
    {
        $userId = $request->user()->id;
        try {
            $limit = $request->get('limit') ?? PAGE_SIZE;
            $tasks = $this->modelTask->load(['participants' => function ($query) use ($userId) {
                return $query->where('user_id', $userId);
            }])
                ->whereStatus(ACTIVE_TASK)
                ->with('taskRewards')
                ->paginate($limit);

        } catch (QueryException $e) {
            return $this->respondNotFound();
        }
        $datas = TaskV2Resource::collection($tasks);
        $pages = [
            'current_page' => (int)$request->get('page'),
            'last_page' => $tasks->lastPage(),
            'per_page'  => (int)$limit,
            'total' => $tasks->lastPage()
        ];

        return $this->respondWithIndex($datas, $pages);
    }

    public function detail(Request $request, $id)
    {
        $userId = $request->user()->id;
        dd($userId);
    }
}
