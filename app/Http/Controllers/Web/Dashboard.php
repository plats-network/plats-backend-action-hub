<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
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

class Dashboard extends Controller
{
    public function __construct(
        private TaskEvent $eventModel,
        private EventService $eventService,
        private TaskService $taskService
    ) {}

    public function index(Request $request)
    {
        if (empty(Auth::user()->id)){
            $active = 0;
        }else{
            $active = 1;
        }
        return view('web.home',['active' => $active]);
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
            dd(1);
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
}
