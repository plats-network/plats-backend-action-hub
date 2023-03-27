<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\VerifyCodeEmail;
use App\Models\Event\EventUserTicket;
use App\Models\Event\TaskEvent;
use App\Models\Event\TaskEventDetail;
use App\Models\Event\UserJoinEvent;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Services\CodeHashService;

class HistoryJoinEventTask extends Controller
{
    public function __construct(private CodeHashService $codeHashService) {}

    public function index(Request $request)
    {
        $code = $request->input('id');

        $user = Auth::user();

        session()->put('code', $code);
        if ($user){
            $taskEventId = TaskEventDetail::where('code',$code)->first();
            $taskId = TaskEvent::where('id', $taskEventId->task_event_id)->first();
            $this->codeHashService->makeCode($taskId->task_id, $user->id);
            return view('web.history');
        }
        return view('web.form_add_user');
    }

    public function createUser(Request $request)
    {

        try {
            if (filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
                $account = $request->input('email');
            } else {
                $account = $request->input('email') . '@gmail.com';
            }
            if (session()->get('code') != null){
               $code = session()->get('code');
                $getTaskEventId = TaskEventDetail::where('code',$code)->first();
                $getTaskId = TaskEvent::where('id',$getTaskEventId->task_event_id)->first();
            }
            $checkUser = User::where('email',$account)->first();
            if ($checkUser){
                return redirect('/client/login');
            }
            $data = [
                'name' => $request->input('name'),
                'email' => $account,
                'password' => '123456a@',
                'confirmation_code' => null,
                'role' => GUEST_ROLE,
                'email_verified_at' => now()
            ];
            $user = User::create($data);
            EventUserTicket::create([
                'user_id' => $user->id,
                'task_id' => $getTaskId->task_id,
                'name' => $request->input('name'),
                'email' => $account,
                'phone' => 0,
                'is_checkin' => true,
                'type' => 1,
            ]);
            Auth::login($user);
        } catch (Exception $exception) {
            return redirect('cws/register')->withErrors(['message' => 'Error: Liên hệ admim']);
        }
        return view('web.history');
    }

    public function apiList()
    {
        $user = Auth::user();
        if (!$user){
            if (session()->get('userC') != null){
                $user = session()->get('userC');
            }
        }

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
        $totalTask = EventUserTicket::where('user_id',$user->id)->where('task_id',$getIdTask->task_id)->first();

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
        $rawData = $this->mergeArray($eventTasks,$eventTaskJoins,$user,count($eventDetailsJoin),$totalTask);

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
            $eventTasks[$key]= TaskEventDetail::where('task_event_id',$key)->orderBy('id', 'ASC')->pluck('id')->toArray();
        }
        return $eventTasks;
    }

    public function mergeArray($eventTaskJoins,$eventTasks,$user,$countDetail,$totalTask)
    {
        $arr = array_values($eventTaskJoins);
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
            if ($totalTask == null){
                $session = '...';
                $booth = '...';
            }else{
                $session = $totalTask->sesion_code;
                $booth = $totalTask->booth_code;
            }
            $a[] = [
                'taskEventName' => $taskEventId->name,
                'nameUser' => $user->name,
                'total' =>  $taskEventId->type == 0 ? $session :  $booth,
                'count' => $countDetail.'/'.count($arr[0]),
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
