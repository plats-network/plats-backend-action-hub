<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event\{TaskEvent, EventUserTicket, UserCode};
use App\Models\Game\{MiniGame};
use Log;

class HomeController extends Controller
{
    public function __construct(
        private TaskEvent $taskEvent,
        private EventUserTicket $eventUserTicket,
        private UserCode $userCode,
        private MiniGame $miniGame,
    )
    {
        // code
    }

    public function miniGame(Request $request, $code)
    {
        try {
            $miniGame = $this->miniGame->whereCode($code)->first();
            if (!$miniGame) { abort(404); }

            $codes = $this->userCode
                ->where('task_event_id', $miniGame->task_event_id)
                ->where('travel_game_id', $miniGame->travel_game_id)
                ->whereType($miniGame->type)
                ->whereIsPrize(false);

            if ($miniGame->is_vip) {
                $event = $this->taskEvent->find($miniGame->task_event_id);
                $userIds = $this->eventUserTicket
                    ->whereTaskId($event->task_id)
                    ->whereIsVip(true)
                    ->pluck('user_id')
                    ->toArray();
                $codes = $codes->whereIn('user_id', $userIds);
            }

            $codes = $codes->inRandomOrder()->pluck('number_code')->toArray();
        } catch (\Exception $e) {
            abort(404);
        }

        return view('game.game', [
            'numbers' => $codes,
            'code' => $code,
            'img' => $miniGame->banner_url ?? 'bg_game_4.png',
            'num' => $miniGame->num,
            'is_locked' => $miniGame->status,
            'event_id' => $miniGame->task_event_id,
            'travel_id' => $miniGame->travel_game_id,
        ]);
    }

    public function updateResult(Request $request)
    {
        try {
            $code = $request->input('code');
            $codeIds = $request->input('ids');
            $miniGame = $this->miniGame->whereCode($code)->first();

            $datas = $this->userCode
                ->where('task_event_id', $miniGame->task_event_id)
                ->where('travel_game_id', $miniGame->travel_game_id)
                ->whereType($miniGame->type)
                ->whereIn('number_code', $codeIds)
                ->update([
                    'is_prize' => true,
                    'name_prize' => $miniGame->type_prize
                ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error'
            ], 500);
        }

        return response()->json([
            'message' => 'Ok'
        ], 200);
    }

    private function resError(Request $request)
    {
        return response()->json([
            'message' => 'Error'
        ], 500);
    }

    private function resOk(Request $request)
    {
        return response()->json([
            'message' => 'Ok'
        ], 200);
    }

    public function gameSession(Request $request, $code)
    {
        try {
            $miniGame = $this->miniGame->whereCode($code)->first();

            if (!$miniGame) {
                abort(404);
            }
            $numbers = [];
            for($i = 0; $i <= 1000; $i++) {
                $numbers[] = $i+1;
            }
        } catch (\Exception $e) {
            abort(404);
        }

        return view('game.demo', [
            'numbers' => $numbers,
            'num' => $miniGame->num,
            'type_name' => $miniGame->is_game,
            'img' => $miniGame->banner_url ?? 'bg_game_4.png',
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
