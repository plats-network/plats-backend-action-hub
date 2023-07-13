<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Mail, Redirect, Session};
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUserForm;
use App\Mail\VerifyCodeEmail;
use App\Models\Event\{
    EventUserTicket,
    TaskEvent,
    TaskEventDetail,
    UserJoinEvent
};
use App\Models\{Task, User};
use App\Services\CodeHashService;

class Job extends Controller
{
    public function __construct(
        private CodeHashService $codeHashService,
        private TaskEventDetail $eventDetail,
        private TaskEvent $taskEvent,
        private UserJoinEvent $joinEvent,
        private Task $task,
        private EventUserTicket $eventUserTicket,
    ) {
        // Code
    }

    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $code = $request->input('id');
            $event = $this->eventDetail->whereCode($code)->first();
            $taskEvent = $this->taskEvent->find($event->task_event_id);
            $task = $this->task->find($taskEvent->task_id);

            if (!$event) {
                notify()->error('Không tồn tại');;
                return redirect()->route('web.home');
            }

            if(!$user) {
                session()->put('guest', [
                    'id' => $code,
                    'type' => 'job'
                ]);
                notify()->error('Vui lòng login để hoàn thành.');

                return redirect()->route('web.formLoginGuest');
            } else {
                if ($event && $event->status == false) {
                    notify()->error('Job locked!');
                } else {
                    $checkJoin = $this->eventUserTicket
                        ->whereUserId($user->id)
                        ->whereTaskId($taskEvent->task_id)
                        ->exists();

                    if (!$checkJoin) {
                        $this->eventUserTicket->create([
                            'user_id' => $user->id,
                            'task_id' => $taskEvent->task_id,
                            'name' => $user->name ?? 'No name',
                            'phone' => $user->phone ?? '098423'.rand(1000, 9999),
                            'email' => $user->email,
                            'type' => 0,
                            'is_checkin' => true
                        ]);
                    }

                    $check = $this->joinEvent
                        ->whereUserId($user->id)
                        ->whereTaskEventDetailId($event->id)
                        ->exists();
                    if (!$check) {
                        $this->joinEvent->create([
                            'user_id' => $user->id,
                            'task_event_detail_id' => $event->id,
                            'agent' => request()->userAgent(),
                            'ip_address' => $request->ip(),
                            'task_id' => optional($taskEvent)->task_id,
                            'task_event_id' => optional($taskEvent)->id
                        ]);
                    }
                }

                return redirect()->route('web.jobEvent', [
                    'id' => optional($task)->code
                ]);
            }
        } catch (\Exception $e) {
            notify()->error('Có lỗi xảy ra');
            return redirect()->route('web.home');
        }
    }
}
