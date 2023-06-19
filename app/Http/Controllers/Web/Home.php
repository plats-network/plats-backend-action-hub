<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\{Task};
use App\Models\Event\{
    EventUserTicket,
    TaskEvent,
    TaskEventDetail,
    UserEventLike,
    UserJoinEvent,
};
use App\Services\Admin\{
    EventService,
    TaskService
};

class Home extends Controller
{
    public function __construct(
        private TaskEvent $eventModel,
        private Task $task,
        private UserJoinEvent $taskDone,
        private TaskEventDetail $eventDetail,
        private EventService $eventService,
        private TaskService $taskService
    ) {}

    public function index(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? 4;
            $events = $this->taskService->search([
                'limit' => $limit,
                'type' => 1,
                'status' => 1
            ]);
        } catch (\Exception $e) {
            Log::error('Errors: ' . $e->getMessage());
        }
        
        return view('web.home', [
            'events' => $events
        ]);
    }

    public function show(Request $request, $id)
    {
        try {
            $event = $this->taskService->find($id);
        } catch (\Exception $e) {
            
        }

        return view('web.events.show', [
            'event' => $event
        ]);
    }

    public function events(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? 8;
            $events = $this->taskService->search([
                'limit' => $limit,
                'type' => 1,
                'status' => 1
            ]);

            // if ($request->ajax()) {
            //     $view = view('data',compact('posts'))->render();
            //     return response()->json(['html'=>$view]);
            // }
        } catch (\Exception $e) {
            Log::error('Errors: ' . $e->getMessage());
        }
        
        return view('web.events.index', [
            'events' => $events
        ]);
    }

    // User work job session, booth
    public function jobEvent(Request $request, $id)
    {
        try {
            $sessionDatas = [];
            $boothDatas = [];

            $task = $this->task->whereCode($id)->first();
            if (!$task) {
                $this->redirectPath();
            }
            $eventSession = $this->eventModel->whereType(TASK_SESSION)->first();
            $eventBooth = $this->eventModel->whereType(TASK_BOOTH)->first();

            $sessions = $this->eventDetail->whereTaskEventId($eventSession->id)->get();
            $booths = $this->eventDetail->whereTaskEventId($eventBooth->id)->get();

            foreach($sessions as $session) {
                $sessionDatas[] = [
                    'id' => $session->id,
                    'user_id' => $request->user()->id,
                    'name' => $session->name,
                    'flag' => $this->checkDoneJob($session->id),
                ];
            }

            foreach($booths as $booth) {
                $boothDatas[] = [
                    'id' => $booth->id,
                    'user_id' => $request->user()->id,
                    'name' => $booth->name,
                    'flag' => $this->checkDoneJob($booth->id),
                ];
            }
        } catch (\Exception $e) {
            $this->redirectPath();
        }

        return view('web.events.job', [
            'sessions' => $sessionDatas,
            'booths' => $boothDatas,
        ]);
    }


    public function webList(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? 8;
            if (empty(Auth::user())) {
                $event = $this->taskService->search(['limit' => $limit,'type' => 1,'status' => 1]);
            } else {
                $event = $this->taskService->search(['limit' => $limit,'type' => 1,'status' => 1]);
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

    public function apiList()
    {
        $user = Auth::user();
        if (empty($user)){
        }
        $eventDetails = UserJoinEvent::where('user_id',$user->id)->get();
        $eventTaskJoins= $this->getEventTaskJoin($eventDetails);
        $eventTasks= $this->getEventTask($eventTaskJoins);
        $rawData = $this->mergeArray($eventTasks,$eventTaskJoins);
        return $this->respondSuccess($rawData);
    }

    public function getEventTaskJoin($data)
    {
        $eventTaskJoins= [];
        foreach($data as $k => $v) {
            $eventTaskJoins[$v['task_event_id']][]=$v->task_event_detail_id;
        }
        return $eventTaskJoins;
    }

    public function getEventTask($data)
    {
        $eventTasks= [];
        foreach($data as $key => $value){
            $eventTasks[$key]= TaskEventDetail::where('task_event_id',$key)->orderBy('id', 'ASC')->pluck('id')->toArray();
        }
        return $eventTasks;
    }

    public function mergeArray($eventTaskJoins,$eventTasks)
    {
        $arr = array_values($eventTasks);
        if (count($arr) > 0){
            $code = TaskEventDetail::where('id',$arr[0][0])->first();
        }
        $c = array_merge_recursive($eventTaskJoins,$eventTasks);
        $a=[];
        foreach ($c as $key => $item){
            $taskEventId = TaskEvent::where('id',$key)->first();
            $taskName = Task::where('id',$taskEventId->task_id)->first();
            $a[] = [
                'taskEventName' => $taskEventId->name,
                'type' => $taskEventId->type == 0 ? 'Session' : 'Booth' ,
                'taskName' => $taskName->name,
                'code' => $code ? $code->code : '',
                'banner' => $taskName->banner_url,
                'taskId' => $taskName->id,
                'created_at' => $taskName->created_at,
            ];
        }
        usort($a, function ($a, $b) {
            return strtotime($a['created_at']) < strtotime($b['created_at']);
        });
        if (count($a) > 0){
            $maxTime = $a[0];
        }else{
            $maxTime = 1;
        }
        return $maxTime;
    }

    private function redirectPath()
    {
        notify()->error('Sự kiện không tồn tại.');
        return redirect()->route('web.home');
    }

    private function checkDoneJob($eventDetailId)
    {
        $userId = Auth::user()->id;

        return $this->taskDone
            ->whereUserId($userId)
            ->whereTaskEventDetailId($eventDetailId)
            ->exists();
    }
}
