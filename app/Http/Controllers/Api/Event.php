<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\Api\QrCode\EventRequest;
use App\Http\Resources\QrCodeResource;

// Model
use App\Models\Task;
use App\Models\Event\{
    UserJoinEvent,
    TaskEventDetail,
    TaskEvent,
    EventUserTicket
};
use App\Http\Resources\{
    TaskResource
};
use Carbon\Carbon;

class Event extends ApiController
{
    public function __construct(
        private UserJoinEvent $userJoinEvent,
        private TaskEventDetail $taskEventDetail,
        private TaskEvent $taskEvent,
        private EventUserTicket $eventUserTicket,
        private Task $task
    ) {}

    public function index(Request $request)
    {
        $limit = $request->get('limit') ?? PAGE_SIZE;
        try {
            $userId = $request->user()->id;

            $events = $this->task
                ->with('userGetTickets')
                ->whereHas('userGetTickets', function($query) use ($userId) {
                    return $query->where('user_id', $userId);
                })
                ->where('end_at', '>=', Carbon::now()->format('Y-m-d H:i:s'))
                ->paginate($limit);
        } catch (\Exception $e) {
            return $this->respondNotFound();
        }

        $datas = TaskResource::collection($events);
        $pages = [
            'current_page' => (int)$request->get('page'),
            'last_page' => $events->lastPage(),
            'per_page'  => (int)$limit,
            'total' => $events->lastPage()
        ];

        return $this->respondWithIndex($datas, $pages);

        return null;
    }
}
