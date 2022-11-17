<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\TaskResource;
use App\Http\Requests\SocialRequest;
use Illuminate\Http\Request;
use App\Models\Task as ModelTask;
use App\Repositories\{
    TaskRepository,
    TaskSocialRepository,
    TaskUserRepository
};
use App\Services\SocialService;
use App\Helpers\ActionHelper;

class Social extends ApiController
{
    /**
     * @param $taskService
     * @param $modelTask
     * @param $taskRepository
     * @param $taskUserRepository
     * @param $taskSocialRepository
     * 
     */
    public function __construct(
        private SocialService $socialService,
        private ModelTask $modelTask,
        private TaskRepository $taskRepository,
        private TaskSocialRepository $taskSocialRepository,
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
        try {
            $user = $request->user();
            $type = ActionHelper::getTypeTwitter($request->type);

            if (is_null($user->twitter) || $user->twitter == '') {
                return $this->respondError('Account twitter not connect!');
            }

            $userSocial = $this->taskSocialRepository->find($socialId);
            // Service
            $isSocial = $this->socialService->performTwitter($user, $type, $id, $userSocial);

            if ($isSocial) {
                return $this->responseMessage('Success!');
            }
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }

        return $this->responseMessage('Not success!');
    }

    /**
     * Start social tasks
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function start($id, Request $request)
    {
        try {
            $userId = $request->user()->id;
            $task = $this->taskRepository->find($id);

            if ($this->taskUserRepository->countUserTaskSocial($userId, $task->id) > 0) {
                return $this->responseMessage('Social task started!');
            }

            $this->socialService->startTaskSocial($userId, $task);
        } catch(\Exception $e) {
            return $this->respondError($e->getMessage());
        }

        return $this->responseMessage('Social task started!');
    }
}
