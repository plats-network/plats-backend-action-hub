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
    UserJoinEvent,
    UserEvent,
};
use App\Models\{Task, User, TravelGame};
use App\Services\CodeHashService;
use Illuminate\Support\Str;

class Job extends Controller
{
    public function __construct(
        private CodeHashService $codeHashService,
        private TaskEventDetail $eventDetail,
        private TaskEvent $taskEvent,
        private UserJoinEvent $joinEvent,
        private Task $task,
        private UserEvent $userEvent,
        private TravelGame $travelGame,
        private EventUserTicket $eventUserTicket,
    ) {
        // Code
    }

    // GET
    // Url: http://event.plats.test/events/code?type=event&id=tuiLOSvRxDUZk2cNTMu5LoA8s4VXxoO4fXe
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
                if ($task) {
                    $checkUserEvent = $this->userEvent
                        ->whereTaskId($task->id)
                        ->whereUserId($user->id)
                        ->exists();

                    if (!$checkUserEvent) {
                        $this->userEvent->create([
                            'user_id' => $user->id,
                            'task_id' => $task->id
                        ]);
                    }
                }

                if ($event && $event->status == false) {
                    notify()->error('Job locked!');

                    return redirect()->route('web.jobEvent', [
                        'id' => optional($task)->code
                    ]);
                } else {
                    return redirect()->route('job.getJob', [
                        'code' => $event->code
                    ]);

                    // $checkJoin = $this->eventUserTicket
                    //     ->whereUserId($user->id)
                    //     ->whereTaskId($taskEvent->task_id)
                    //     ->exists();

                    // if (!$checkJoin) {
                    //     $this->eventUserTicket->create([
                    //         'user_id' => $user->id,
                    //         'task_id' => $taskEvent->task_id,
                    //         'name' => $user->name ?? 'No name',
                    //         'phone' => $user->phone ?? '098423'.rand(1000, 9999),
                    //         'email' => $user->email,
                    //         'is_checkin' => true
                    //     ]);
                    // }

                    // $check = $this->joinEvent
                    //     ->whereUserId($user->id)
                    //     ->whereTaskEventDetailId($event->id)
                    //     ->exists();

                    // if (!$check) {
                    //     $this->joinEvent->create([
                    //         'user_id' => $user->id,
                    //         'task_event_detail_id' => $event->id,
                    //         'agent' => request()->userAgent(),
                    //         'ip_address' => $request->ip(),
                    //         'task_id' => optional($taskEvent)->task_id,
                    //         'task_event_id' => optional($taskEvent)->id
                    //     ]);
                    // }
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

    // TODO
    // method: GET
    // url: http://event.plats.test/quiz/tuiLOSvRxDUZk2cNTMu5LoA8s4VXxoO4fXe
    public function getJob(Request $request, $code) {
        try {
            $detail = $this->eventDetail->whereCode($code)->first();
            if (!$detail) {
                notify()->error('Errors');
                return redirect()->route('web.home');
            }
            $taskEvent = $this->taskEvent->find($detail->task_event_id);
            $taskId = $taskEvent->task_id;
            $task = $this->task->find($taskId);
            $user = $request->user();

            if (!$detail) {
                notify()->error('Có lỗi xảy ra');
                return redirect()->route('web.home');
            }

            $checkJoin = $this->eventUserTicket
                ->whereTaskId($taskId)
                ->whereUserId($user->id)
                ->exists();
            if (!$checkJoin) {
                $this->eventUserTicket->create([
                    'name' => $user->name,
                    'phone' => $user->phone ?? '092384234',
                    'email' => $user->email,
                    'task_id' => $taskId,
                    'user_id' => $user->id,
                    'is_checkin' => true,
                    'hash_code' => Str::random(35)
                ]);
            }

            $checkEventJob = $this->joinEvent
                ->where('task_event_detail_id', $detail->id)
                ->whereUserId($user->id)
                ->exists();

            if (!$checkEventJob) {
                $this->joinEvent->create([
                    'task_event_detail_id' => $detail->id,
                    'user_id' => $user->id,
                    'task_id' => $taskId,
                    'task_event_id' => $detail->task_event_id,
                ]);
            }
            if ($detail->is_question == true) {
                notify()->success('Quét QR code success');

                return redirect()->route('web.jobEvent', [
                    'id' => $task->code
                ]);
            }
        } catch (\Exception $e) {
            notify()->error('Có lỗi xảy ra');
            return redirect()->route('web.home');
        }

        return view('web.events.quiz', [
            'detail' => $detail
        ]);
    }

    /**
     * List travel game
     *
     * method: GET
     * url: http://event.plats.test/info/{task_id}
     * author: suoi
     */
    public function getTravelGame(Request $request, $taskId)
    {
        try {
            $travelBoots = [];
            $travelSessions = [];

            $event = $this->task->find($taskId);
            $session = $this->taskEvent->whereTaskId($taskId)->whereType(TASK_SESSION)->first();
            $booth = $this->taskEvent->whereTaskId($taskId)->whereType(TASK_BOOTH)->first();

            $travelSessionIds = $this->eventDetail->select('travel_game_id')->distinct()->whereTaskEventId($session->id)->pluck('travel_game_id')->toArray();
            $travelBootsIds = $this->eventDetail->select('travel_game_id')->distinct()->whereTaskEventId($session->id)->pluck('travel_game_id')->toArray();

            $travelSessions = $this->travelGame->whereIn('id', $travelSessionIds)->get();
            $travelBooths = $this->travelGame->whereIn('id', $travelSessionIds)->get();
        } catch (\Exception $e) {
            abort(404);
        }

        return view('web.events.travel_game', [
            'event' => $event,
            'travelSessions' => $travelSessions,
            'travelBooths' => $travelBooths
        ]);
    }
}
