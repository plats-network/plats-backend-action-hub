<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event\EventUserTicket;
use App\Models\Event\TaskEvent;
use App\Models\Event\TaskEventDetail;
use App\Models\Event\UserJoinEvent;
use App\Models\Task;
use App\Services\Admin\EventService;
use App\Services\Admin\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
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
        if (empty(Auth::user()->id)){
            $active = 0;
        }else{
            $active = 1;
        }
        return view('web.home',['active' => $active]);
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
        $rawData = $this->mergeArray($eventTasks,$eventTaskJoins,$user);
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
        $c = array_merge_recursive($eventTaskJoins,$eventTasks);
        $a=[];
        foreach ($c as $key => $item){
            $taskEventId = TaskEvent::where('id',$key)->first();
            $taskName = Task::where('id',$taskEventId->task_id)->first();
            $a[] = [
                'taskEventName' => $taskEventId->name,
                'type' => $taskEventId->type == 0 ? 'Session' : 'Booth' ,
                'taskName' => $taskName->name,
//                'idDetailEventTask' => $taskName->name,
                'banner' => $taskName->banner_url,
                'taskId' => $taskName->id,
                'created_at' => $taskName->created_at,
            ];
        }
        usort($a, function ($a, $b) {
            return strtotime($a['created_at']) < strtotime($b['created_at']);
        });
        $maxTime = $a[0];
        return $maxTime;
    }
}
