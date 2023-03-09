<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event\TaskEvent;
use App\Models\Event\TaskEventDetail;
use App\Models\Event\UserJoinEvent;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryJoinEventTask extends Controller
{
    public function index()
    {
        return view('web.history');
    }

    public function apiList()
    {
        $user = Auth::user();
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
            $eventTasks[$key]= TaskEventDetail::where('task_event_id',$key)->pluck('id')->toArray();
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
            $grouped = [];
            foreach(array_count_values($item) as $value => $count)
            {
                $eventDetailName = TaskEventDetail::where('id',$value)->first();
                if ($eventDetailName){
                    $grouped[] = [
                        'name' => $eventDetailName->name,
                        'active' => count(array_intersect($item, array($value)))
                    ];
                }
            }
            $a[] = [
                'taskEventName' => $taskEventId->name,
                'type' => $taskEventId->type == 0 ? 'Session' : 'Booth' ,
                'taskName' => $taskName->name,
                'taskId' => $taskName->id,
                'eventDetail' => $grouped,
            ];
        }
        return $a;
    }
}
