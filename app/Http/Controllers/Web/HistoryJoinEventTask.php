<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event\TaskEvent;
use App\Models\Event\TaskEventDetail;
use App\Models\Event\UserJoinEvent;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HistoryJoinEventTask extends Controller
{
    public function __construct() {}

    public function index(Request $request)
    {
        $code = $request->input('id');
        $user = Auth::user();
        $session = session()->put('code', $code);

        if ($user){
            return view('web.history');
        }

        return redirect('/client/login');
    }

    public function apiList()
    {
        $user = Auth::user();
        $code = session()->get('code');
        $getIdEventDetail = TaskEventDetail::where('code', $code)->first();
        if (!$getIdEventDetail){
            return true;
        }
        $getIdTask = TaskEvent::where('id',$getIdEventDetail->task_event_id)->first();

        if ($getIdEventDetail->status == false){
            $eventDetailsJoin = UserJoinEvent::where('user_id',$user->id)
                ->where('task_event_id',$getIdEventDetail->task_event_id)
                ->where('task_id',$getIdTask->task_id)
                ->get();
            $eventTaskJoins= $this->getEventTaskJoin($eventDetailsJoin);
            $eventTasks= $this->getEventTask($eventTaskJoins);
            $rawData = $this->mergeArray($eventTasks, $eventTaskJoins);
            $rawData['active'] = 1;

            return $this->respondSuccess($rawData);
        }

        $dataInsert = [
            'user_id' => $user->id,
            'task_event_detail_id' => $getIdEventDetail->id,
            'task_id' => $getIdTask->task_id,
            'task_event_id' => $getIdEventDetail->task_event_id,
        ];
        $check = UserJoinEvent::where('user_id',$user->id)
            ->where('task_event_detail_id',$getIdEventDetail->id)
            ->first();
        if (!$check){
            UserJoinEvent::create($dataInsert);
        }

        $eventDetailsJoin = UserJoinEvent::where('user_id',$user->id)
            ->where('task_event_id',$getIdEventDetail->task_event_id)
            ->where('task_id',$getIdTask->task_id)
            ->get();
        $eventTaskJoins= $this->getEventTaskJoin($eventDetailsJoin);
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
        foreach($data as $key => $value) {
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

            foreach(array_count_values($item) as $value => $count) {
                $eventDetailName = TaskEventDetail::where('id',$value)->first();

                if ($eventDetailName) {
                    $grouped[] = [
                        'name' => $eventDetailName->name,
                        'active' => count(array_intersect($item, array($value)))
                    ];
                }
            }

            $a[] = [
                'taskEventName' => $taskEventId->name,
                'banner' => $taskName->banner_url,
                'type' => $taskEventId->type == 0 ? 'Session' : 'Booth' ,
                'taskName' => $taskName->name,
                'taskId' => $taskName->id,
                'eventDetail' => $grouped,
            ];
        }

        return $a;
    }
}
