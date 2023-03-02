<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Admin\TaskRequest;
use App\Http\Resources\Admin\EventResource;
use App\Models\Event\TaskEvent;
use App\Models\Event\TaskEventDetail;
use App\Models\Event\TaskEventReward;
use App\Models\Event\UserEventLike;
use App\Services\Admin\EventService;
use App\Services\Admin\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Event extends ApiController
{

    public function __construct(
        private TaskEvent   $eventModel,
        private EventService $eventService,
        private TaskService $taskService
    )
    {
    }

    public function index(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? PAGE_SIZE;
            if (empty(Auth::user()->role)) {
                $event = $this->taskService->search(['limit' => $limit,'type' => USER_ROLE]);
            } else {
                $event = $this->taskService->search(['limit' => $limit, 'creator_id' => Auth::user()->id,'type' => USER_ROLE]);
                foreach ($event as &$item){
                    $data = UserEventLike::where('task_id',$item->id)->where('user_id',Auth::user()->id)->first();
                    if ($data){
                        $item['like_active'] = 1;
                    }else{
                        $item['like_active'] = 0;
                    }
                }
            }
            return response()->json($event);
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        try {
            $this->eventService->store($request);
            $mess = empty($request->input('id')) ? 'Create event done!' : 'Update event done!';
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }

        return $this->responseMessage($mess);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        try {
            $event = $this->eventModel->with('task','eventDetails')->findOrFail($id);
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }

        return $this->respondWithResource(new EventResource($event));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        try {
            $event = $this->eventModel->findOrFail($id);
            $event->delete();
            TaskEventDetail::where('task_event_id',$id)->delete();
            TaskEventReward::where('task_id',$event->task_id)->delete();
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }

        return $this->responseMessage($event);
    }
}
