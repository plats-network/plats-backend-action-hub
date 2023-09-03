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
    UserCode,
};
use App\Models\{Task, User, TravelGame, Sponsor, SponsorDetail, UserSponsor};
use App\Services\{CodeHashService, TaskService};
use Illuminate\Support\Str;

class Job extends Controller
{
    public function __construct(
        private CodeHashService $codeHashService,
        private TaskEventDetail $eventDetail,
        private TaskEvent $taskEvent,
        private UserJoinEvent $joinEvent,
        private Task $task,
        private UserCode $userCode,
        private Sponsor $sponsor,
        private SponsorDetail $sponsorDetail,
        private UserSponsor $userSponsor,
        private UserEvent $userEvent,
        private TravelGame $travelGame,
        private EventUserTicket $eventUserTicket,
        private TaskService $taskService,
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

                    return redirect()->route('job.getJob', [
                        'code' => $event->code
                    ])->with('error', "Job locked!");
                } else {
                    return redirect()->route('job.getJob', [
                        'code' => $event->code
                    ]);
                }

                return redirect()->route('web.jobEvent', [
                    'id' => $task->code
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
            $user = Auth::user();

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
            $taskEvent = $this->taskEvent->find($detail->task_event_id);

            if (!$checkEventJob) {
                if (!$detail->status) {
                    notify()->error('QR code locked');
                    return redirect()->route('web.jobEvent', [
                        'id' => $task->code,
                        'type' => $taskEvent->type
                    ]);
                } else {
                    // $taskEvent = $this->taskEvent->find($detail->task_event_id);
                    $isImportant = $taskEvent->type == 0 ? $detail->is_question : $detail->is_required;

                    $this->joinEvent->create([
                        'task_event_detail_id' => $detail->id,
                        'travel_game_id' => $detail->travel_game_id,
                        'user_id' => $user->id,
                        'task_id' => $taskId,
                        'task_event_id' => $detail->task_event_id,
                        'type' => $taskEvent->type,
                        'is_important' => $isImportant
                    ]);
                }

            }
            if ($detail->is_question == false) {
                notify()->success('Quét QR code success');

                return redirect()->route('web.jobEvent', [
                    'id' => $task->code,
                    'type' => $taskEvent->type
                ]);
            }
        } catch (\Exception $e) {
            notify()->error('Có lỗi xảy ra');
            return redirect()->route('web.home');
        }

        return view('web.events.quiz', [
            'detail' => $detail,
            'task_code' => $task->code
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
            $event = $this->task->find($taskId);

            $travelSessions = [];
            $session = $this->taskEvent->whereTaskId($taskId)->whereType(TASK_SESSION)->first();
            $travelSessionIds = $this->eventDetail
                ->select('travel_game_id')
                ->distinct()
                ->whereTaskEventId($session->id)
                ->pluck('travel_game_id')
                ->toArray();

            $travelBoots = [];
            $booth = $this->taskEvent->whereTaskId($taskId)->whereType(TASK_BOOTH)->first();
            $travelBootsIds = $this->eventDetail
                ->select('travel_game_id')
                ->distinct()
                ->whereTaskEventId($booth->id)
                ->pluck('travel_game_id')
                ->toArray();

            $travelSessions = $this->travelGame->whereIn('id', $travelSessionIds)->get();
            $travelBooths = $this->travelGame->whereIn('id', $travelBootsIds)->get();

            // dd($travelBooths->pluck('id')->toArray(), $travelSessions->pluck('id')->toArray());


            // Start
            $userId = Auth::user()->id;
            $this->taskService->genCodeByUser($userId, $taskId, $travelSessionIds, $travelBootsIds, $session->id, $booth->id);
        } catch (\Exception $e) {
            dd($e->getMessage());
            abort(404);
        }

        return view('web.events.travel_game', [
            'event' => $event,
            'travelSessions' => $travelSessions,
            'travelBooths' => $travelBooths
        ]);
    }

    // New sponsor
    // method: GET
    // URL: /sponsor/new
    public function newSponsor(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $infoParams = $request->session()->get('sponsor-'.$userId);
            if (!$request->session()->has('sponsor-'.$userId)) {
                $request->session()->put('sponsor-'.$userId, [
                    'task_id' => $request->input('event_id'),
                    'type' => $request->input('type'),
                    'amount' => $request->input('amount'),
                    'detail_id' => $request->input('detail_id')
                ]);
                $infoParams = $request->session()->get('sponsor-'.$userId);
            }

            $event = $this->task->find($infoParams['task_id']);
            if (!$event) { abort(404); }

            $sponsor = $this->sponsor->whereTaskId($event->id)->first();
            $detail = $this->sponsorDetail->find($infoParams['detail_id']);

            if (!$sponsor || !$detail) { abort(404); }
        } catch (\Exception $e) {
            abort(404);
        }

        return view('web.events.new_sponsor', [
            'event' => $event,
            'sponsor' => $sponsor,
            'detail' => $detail
        ]);
    }

    // Save sponsor
    // method: POST
    // URL: /sponsor/pay
    public function saveSponsor(Request $request)
    {
        try {
            $taskId = $request->input('task_id');
            $userId = Auth::user()->id;
            $this->userSponsor->create([
                'user_id' => $userId,
                'task_id' => $taskId,
                'sponsor_id' => $request->input('sponsor_id'),
                'sponsor_detail_id' => $request->input('sponsor_detail_id'),
                'amount' => (int) $request->input('amount'),
                'note' => $request->input('note'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [
                    'message' => 'Error: ' . $e->getMessage()
                ]
            ], 500);
        }

        return response()->json([
            'data' => [
                'message' => 'Successful'
            ]
        ], 200);
    }
}
