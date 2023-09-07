<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\{Task, User, TravelGame, Sponsor};
use Illuminate\Support\Str;
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
use Carbon\Carbon;
use DB;

class Home extends Controller
{
    public function __construct(
        private TaskEvent $eventModel,
        private Task $task,
        private User $user,
        private Sponsor $sponsor,
        private UserJoinEvent $taskDone,
        private TaskEventDetail $eventDetail,
        private EventUserTicket $eventUserTicket,
        private EventService $eventService,
        private TaskService $taskService,
        private TravelGame $travelGame,
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
            $user = Auth::user();
            $event = $this->taskService->find($id);
            $sponsor = $this->sponsor->whereTaskId($id)->first();
            $checkSponsor = session()->get('sponsor-'.optional($user)->id);

            if ($request->session()->has('sponsor-' . optional($user)->id)) {
               $request->session()->forget('sponsor-' . optional($user)->id);
            }
        } catch (\Exception $e) {
            notify()->error('Error show event');
        }

        return view('web.events.show', [
            'event' => $event,
            'user' => $user,
            'sponsor' => $sponsor
        ]);
    }

    // Get ticket
    public function orderTicket(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $name = $request->input('first').' '.$request->input('last');
            $taskId = $request->input('task_id');
            $email = $request->input('email');

            if (!$user) {
                $user = $this->user->whereEmail($email)->first();
                if (!$user) {
                    $user = $this->user->create([
                        'name' => $name,
                        'email' => $request->input('email'),
                        'password' => '123456a@',
                        'phone' => $request->input('phone'),
                        'role' => GUEST_ROLE,
                        'email_verified_at' => now(),
                        'confirm_at' => now(),
                        'status' => USER_CONFIRM
                    ]);
                }

                Auth::login($user);
            }

            $check = $this->eventUserTicket
                ->whereUserId($user->id)
                ->whereTaskId($taskId)
                ->exists();

            if (!$check) {
                $this->eventUserTicket->create([
                    'name' => $name,
                    'phone' => $request->input('phone'),
                    'email' => $request->input('email'),
                    'task_id' => $taskId,
                    'user_id' => $user->id,
                    'hash_code' => Str::random(35)
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            notify()->error('Error submit ticket');
            return redirect()->route('web.home');
        }

        notify()->success('Get ticket success');
        return redirect()->route('web.events.show', [
            'id' => $taskId
        ]);
    }

    public function events(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? 100;
            $events = $this->taskService->search([
                'limit' => $limit,
                'type' => 1,
                'status' => 1
            ]);
        } catch (\Exception $e) {
            Log::error('Errors: ' . $e->getMessage());
        }
        
        return view('web.events.index', [
            'events' => $events
        ]);
    }

    // User work job session, booth
    // method: GET
    // url: http://event.plats.test/event-job/fOtjr347cL9nHwWTox1J
    public function jobEvent(Request $request, $id)
    {
        try {

            $sessionDatas = [];
            $boothDatas = [];
            $user = Auth::user();
            $task = $this->task->whereCode($id)->first();
            $sessionNFT = session()->get('nft-'.$user->id);

            if (!$task) {
                $this->redirectPath();
            }

            $eventSession = $this->eventModel->whereTaskId($task->id)->whereType(TASK_SESSION)->first();
            $eventBooth = $this->eventModel->whereTaskId($task->id)->whereType(TASK_BOOTH)->first();
            $sessions = $this->eventDetail->whereTaskEventId($eventSession->id)->orderBy('sort', 'asc')->get();
            $booths = $this->eventDetail->whereTaskEventId($eventBooth->id)->orderBy('sort', 'asc')->get();
            // dd($sessions);

            foreach($sessions as $session) {
                $travel = $this->travelGame->find($session->travel_game_id);
                $job = $this->taskDone
                    ->whereUserId($user->id)
                    ->whereTaskEventDetailId($session->id)
                    ->first();

                $sessionDatas[] = [
                    'id' => $session->id,
                    'travel_game_id' => $session->travel_game_id,
                    'travel_game_name' => $travel->name,
                    'user_id' => $request->user()->id,
                    'name' => $session->name,
                    'desc' => $session->description,
                    'date' => $job ? Carbon::parse($job->created_at)->format('Y-m-d') : '',
                    'time' => $job ? Carbon::parse($job->created_at)->format('H:i') : '',
                    'required' => $session->is_required,
                    'flag' => $this->checkDoneJob($session->id),
                ];
            }

            foreach($booths as $booth) {
                $travel = $this->travelGame->find($booth->travel_game_id);
                $job = $this->taskDone
                    ->whereUserId($user->id)
                    ->whereTaskEventDetailId($booth->id)
                    ->first();

                $boothDatas[] = [
                    'id' => $booth->id,
                    'travel_game_id' => $booth->travel_game_id,
                    'travel_game_name' => $travel->name,
                    'user_id' => $request->user()->id,
                    'name' => $booth->name,
                    'desc' => $booth->description,
                    'date' => $job ? Carbon::parse($job->created_at)->format('Y-m-d') : '',
                    'time' => $job ? Carbon::parse($job->created_at)->format('H:i') : '',
                    'required' => $booth->is_required,
                    'flag' => $this->checkDoneJob($booth->id),
                ];
            }

            $groupSessions = [];
            $groupBooths = [];
            foreach($sessionDatas as $item) {
                $groupSessions[$item['travel_game_id']][] = $item;
            }
            foreach($boothDatas as $item) {
                $groupBooths[$item['travel_game_id']][] = $item;
            }
        } catch (\Exception $e) {
            $this->redirectPath();
        }

        return view('web.events.job', [
            'groupBooths' => $groupBooths,
            'groupSessions' => $groupSessions,
            'task_id' => $task->id,
            'id' => $id,
            'url' => $sessionNFT && $sessionNFT['url'] ? $sessionNFT['url'] : null,
            'nft' => $sessionNFT && $sessionNFT['nft'] ? 1 : 0
        ]);
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
