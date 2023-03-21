<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\Api\QrCode\EventRequest;
use App\Http\Resources\QrCodeResource;
// Model
use App\Models\Event\{
    UserJoinEvent,
    TaskEventDetail,
    TaskEvent,
    EventUserTicket
};
use DB;

class QrCode extends ApiController
{
    public function __construct(
        private UserJoinEvent $userJoinEvent,
        private TaskEventDetail $taskEventDetail,
        private TaskEvent $taskEvent,
        private EventUserTicket $eventUserTicket
    ) {}

    public function qrEvent(EventRequest $request)
    {
        $data = [];
        $dataStatusess = [];

        try {
            $userId = $request->user()->id;
            $code = $request->input('code');
            $type = $request->input('type');

            if ($type == 'event') {
                $eventDetail = $this->taskEventDetail->whereCode($code)->first();
                $taskEvent = $this->taskEvent->findOrFail($eventDetail->task_event_id);
                $userJoinEvent = $this->userJoinEvent
                    ->whereUserId($userId)
                    ->whereTaskEventDetailId(optional($eventDetail)->id)
                    ->first();

                $eventUserTicket = $this->eventUserTicket
                    ->whereUserId($userId)
                    ->whereTaskId($taskEvent->task_id)
                    ->first();

                if (!$eventDetail) {
                    return $this->respondError('Job no found!', 404);
                }

                if (!$userJoinEvent) {
                    $data = [
                        'user_id' => $userId,
                        'task_event_detail_id' => $eventDetail->id,
                        'task_id' => $taskEvent->task_id,
                        'task_event_id' => $taskEvent->id
                    ];

                    $this->userJoinEvent->create($data);
                }

                $data = [
                    'task_id' => $taskEvent->task_id
                ];

                $dataStatusess = [
                    'flag_session' => optional($eventUserTicket)->sesion_code ? true : false,
                    'num_session' => optional($eventUserTicket)->sesion_code ?? '',
                    'flag_booth' => optional($eventUserTicket)->booth_code ? true : false,
                    'num_booth' => optional($eventUserTicket)->booth_code ?? ''
                ];
            } elseif ($type == 'checkin') {
                $ticket = $this->eventUserTicket->whereHashCode($code)->first();

                if (!$ticket) {
                    return $this->respondError('Ticket not found!', 404);
                }

                if ($ticket->is_checkin == true) {
                    $data = [
                        'task_id' => $ticket->task_id,
                        'status_message' => 'Ticket checkined!'
                    ];
                } else {
                    $ticket->update(['is_checkin' => true]);
                    $data = [
                        'task_id' => $ticket->task_id,
                        'status_message' => 'Checkin done!'
                    ];
                }
            }
        } catch (\Exception $e) {
            return $this->respondError("QR không đúng, vui lòng kiểm tra lại!", 500);
        }

        return $this->respondWithData(array_merge($data, $dataStatusess), 'Done');
    }
}
