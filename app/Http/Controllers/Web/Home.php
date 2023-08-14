<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\{Task, TravelGame};
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

class Home extends Controller
{
    public function __construct(
        private TaskEvent $eventModel,
        private Task $task,
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
            $event = $this->taskService->find($id);
        } catch (\Exception $e) {
            
        }

        return view('web.events.show', [
            'event' => $event
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
    // url: http://event.plats.test/info/99dc826f-5c60-4ebd-af48-d709d761a8ff
    public function jobEvent(Request $request, $id)
    {
        try {
            $sessionDatas = [];
            $boothDatas = [];

            $user = Auth::user();
            $task = $this->task->whereCode($id)->first();
            if (!$task) {
                $this->redirectPath();
            }

            $eventSession = $this->eventModel->whereTaskId($task->id)->whereType(TASK_SESSION)->first();
            $eventBooth = $this->eventModel->whereTaskId($task->id)->whereType(TASK_BOOTH)->first();
            $sessions = $this->eventDetail->whereTaskEventId($eventSession->id)->get();
            $booths = $this->eventDetail->whereTaskEventId($eventBooth->id)->get();

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
                    'desc' => $session->description,
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
