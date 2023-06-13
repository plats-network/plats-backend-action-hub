<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event\{TaskEvent, EventUserTicket};
use Log;

class HomeController extends Controller
{
    public function __construct(
        private TaskEvent $taskEvent,
        private EventUserTicket $eventUserTicket,
    )
    {
        // code
    }

    public function gameSession(Request $request, $code)
    {
        try {
            $taskEvent = $this->taskEvent
                ->whereCode($code)
                ->firstOrFail();

            $events = $this->eventUserTicket
                ->whereTaskId($taskEvent->task_id)
                ->whereNotNull('sesion_code')
                ->whereIsSession(false)
                ->inRandomOrder()
                ->get();
            // dd($events);
        } catch (\Exception $e) {
            abort(404);
        }

        return view('game.session', [
            'events' => $events,
            'task_id' => $taskEvent->task_id
        ]);
    }

    public function gameBooth(Request $request, $code)
    {
        try {
            $taskEvent = $this->taskEvent
                ->whereCode($code)
                ->firstOrFail();

            $events = $this->eventUserTicket
                ->whereTaskId($taskEvent->task_id)
                ->whereNotNull('booth_code')
                ->whereIsBooth(false)
                ->inRandomOrder()
                ->get();
        } catch (\Exception $e) {
            abort(404);
        }

        return view('game.booth', [
            'events' => $events,
            'task_id' => $taskEvent->task_id
        ]);
    }

    public function updateSession($task_id, $num, Request $request)
    {
        try {
            $event = $this->eventUserTicket
                ->whereTaskId($task_id)
                ->whereNotNull('sesion_code')
                ->whereIsSession(false)
                ->whereSesionCode($num)
                ->first();
            if ($event) {
                $event->update(['is_session' => true]);
            }
        } catch (\Exception $e) {
            
        }

        return response()->json([
            'status' => 'ok',
        ], 200);
    }

    public function updateBooth($task_id, $num, Request $request)
    {
        try {
            $event = $this->eventUserTicket
                ->whereNotNull('booth_code')
                ->whereTaskId($task_id)
                ->whereIsBooth(false)
                ->whereBoothCode($num)
                ->first();
            if ($event) {
                $event->update(['is_booth' => true]);
            }
        } catch (\Exception $e) {

        }

        return response()->json([
            'status' => 'ok',
        ], 200);
    }
}
