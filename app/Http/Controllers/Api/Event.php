<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\Api\QrCode\EventRequest;
use App\Http\Resources\QrCodeResource;
// Model
use App\Models\Task;
use App\Models\Event\{UserEvent};
use App\Http\Resources\{
    TaskResource
};
use Carbon\Carbon;

class Event extends ApiController
{
    public function __construct(
        private Task $task,
        private UserEvent $userEvent,
    ) {}

    public function index(Request $request)
    {
        $datas = [];
        $userId = $request->user()->id;

        $userEvents = $this->userEvent
            ->with(['user', 'task'])
            ->whereUserId($userId)
            ->whereStatus(0)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        foreach($userEvents as $item) {
            $datas[] = [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'event_id' => $item->task_id,
                'name' => optional($item->task)->name,
                'image_path' => optional($item->task)->banner_url
            ];
        }

        return response()->json([
            'message' => 'List event improgress',
            'status' => 'success',
            'data' => $datas
        ], 200);
    }
}
