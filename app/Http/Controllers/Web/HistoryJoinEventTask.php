<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Mail, Redirect, Session};
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUserForm;
use App\Mail\VerifyCodeEmail;
use App\Models\Event\{EventUserTicket, TaskEvent, TaskEventDetail, UserJoinEvent};
use App\Models\{Task, User};
use App\Services\CodeHashService;

class HistoryJoinEventTask extends Controller
{
    public function __construct(
        private CodeHashService $codeHashService,
        private TaskEventDetail $eventDetail,
    ) {
        // Code
    }

    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $code = $request->input('id');
            $event = $this->eventDetail->whereCode($code)->first();

            if (!$event) {
                notify()->error('Không tồn tại');;
                return redirect()->route('web.home');
            }

            if(!$user) {
                session()->put('code', $code);
                notify()->error('Vui lòng login để hoàn thành.');

                return redirect()->route('web.formLoginGuest');
            } else {
                return redirect()->route('web.jobEvent', [
                    // http://event.plats.test/event-job/ewqf2143e
                    'id' => 'ewqf2143e'
                ]);
            }
        } catch (\Exception $e) {
            notify()->error('Có lỗi xảy ra');
            return redirect()->route('web.home');
        }
    }

    public function createUser(CreateUserForm $request)
    {
        try {
            if (filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
                $account = $request->input('email');
            } else {
                $account = $request->input('email') . '@gmail.com';
            }
            $checkUser = User::where('email',$account)->first();
            if ($checkUser){
                Auth::login($checkUser);
                return view('web.history');
            }
            if (session()->get('code') != null) {
                $code = session()->get('code');
                $getTaskEventId = TaskEventDetail::where('code',$code)->first();
                $getTaskId = TaskEvent::where('id',$getTaskEventId->task_event_id)->first();
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
            }
        } catch (Exception $exception) {
            return redirect('cws/register')->withErrors(['message' => 'Error: Liên hệ admim']);
        }
        return view('web.history');
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
        $this->codeHashService->makeCode($getIdTask->task_id, $user->id);
        $totalTask = EventUserTicket::where('user_id',$user->id)->where('task_id',$getIdTask->task_id)->first();
        $eventDetailsJoin = UserJoinEvent::where('user_id',$user->id)
            ->where('task_event_id',$getIdEventDetail->task_event_id)
            ->where('task_id',$getIdTask->task_id)
            ->get();
        $eventTaskJoins= $this->getEventTaskJoin($eventDetailsJoin);
        $eventTasks= $this->getEventTask($eventTaskJoins);
        if ($getIdEventDetail->status == false){
            $eventTaskJoins= $this->getEventTaskJoin($eventDetailsJoin);
            $eventTasks= $this->getEventTask($eventTaskJoins);
            $rawData = $this->mergeArray($eventTasks, $eventTaskJoins,$user,count($eventDetailsJoin),$totalTask);
            $rawData['active'] = 1;

            return $this->respondSuccess($rawData);
        }
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
            $eventTasks[$key]= TaskEventDetail::where('task_event_id',$key)
                ->orderBy('id', 'ASC')
                ->pluck('id')
                ->toArray();
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
