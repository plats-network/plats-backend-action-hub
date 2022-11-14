<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\{CheckInTaskRequest, CreateTaskRequest, StartTaskRequest};
use App\Http\Resources\{TaskResource, TaskUserResource, TaskDogingResource};
use App\Services\TaskService;
use App\Http\Requests\SocialRequest;
use App\Models\Task as ModelTask;
use App\Models\TaskUser;
use Illuminate\Database\QueryException;
use App\Repositories\{LocationHistoryRepository, TaskRepository, TaskUserRepository};
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\{DB, Http};
use Carbon\Carbon;

class Social extends ApiController
{
    /**
     * @param $taskService
     * @param $modelTask
     * @param $locationHistoryRepository
     * @param $taskRepository
     * @param $taskUserRepository
     * 
     */
    public function __construct(
        private TaskService $taskService,
        private ModelTask $modelTask,
        private LocationHistoryRepository $locationHistoryRepository,
        private TaskRepository $taskRepository,
        private TaskUserRepository $taskUserRepository
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        try {
            $limit = $request->get('limit') ?? PAGE_SIZE;
            $socials = $this->modelTask->load(['participants' => function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                }])
                ->whereStatus(ACTIVE_TASK)
                ->whereType(TYPE_SOCIAL)
                ->paginate($limit);
        } catch (QueryException $e) {
            return $this->respondNotFound();
        }

        $datas = TaskResource::collection($socials);
        $pages = [
            'current_page' => (int)$request->get('page'),
            'last_page' => $socials->lastPage(),
            'per_page'  => (int)$limit,
            'total' => $socials->lastPage()
        ];

        return $this->respondWithIndex($datas, $pages);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SocialRequest $request, $id, $socialId)
    {
        $user = $request->user();

        if (is_null($user->twitter) || $user->twitter == '') {

        }

        dd($user);
    }
}
