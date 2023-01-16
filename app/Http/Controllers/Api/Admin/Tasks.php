<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\RewardResource;
use App\Http\Resources\Admin\TaskResource;
use App\Models\Task;
use App\Models\TaskGroup;
use App\Models\TaskLocation;
use App\Models\TaskLocationJob;
use App\Services\Admin\TaskService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            $rewards = $this->taskService->search(['limit' => $limit, 'creator_id' => Auth::user()->id]);
        } else {
            $rewards = $this->taskService->search(['limit' => $limit]);
        }
        $datas = TaskResource::collection($rewards);
        $pages = [
            'current_page' => (int)$request->get('page'),
            'last_page' => $rewards->lastPage(),
            'per_page' => (int)$limit,
            'total' => $rewards->total()
        ];

        return $this->respondWithIndex($datas, $pages);
    }

    public function store(Request $request)
    {

        if ($request->filled('id')) {
            $checkStatusTask = Task::where('status', TASK_PUBLIC)->where('id', $request->input('id'))->first();
            if ($checkStatusTask) {
                return $this->respondError('Can’t edit a published task', 422);
            }
        }
        $reward = $this->taskService->store($request);
        return $this->responseMessage('success');
    }

    public function edit($id)
    {
        $task = Task::with('taskGalleries', 'groupTasks', 'taskSocials', 'taskLocations')->find($id);
        return $this->responseMessage($task);
    }

    public function destroy($id)
    {
        $checkStatusTask = Task::where('status', TASK_DRAFT)->where('id', $id)->first();
        if (!$checkStatusTask) {
            return $this->respondError('Can’t delete a published task', 422);
        }
        $getIdLocatios = TaskLocation::where('task_id', $id)->pluck('id');
        TaskLocationJob::whereIn('task_location_id', $getIdLocatios)->delete();
        Task::where('status', TASK_DRAFT)->where('id', $id)->delete();
        TaskGroup::where('task_id', $id)->delete();
        $checkStatusTask->taskGalleries()->delete();
        $checkStatusTask->taskSocials()->delete();
        $checkStatusTask->taskLocations()->delete();
        return $this->responseMessage('success');
    }
}
