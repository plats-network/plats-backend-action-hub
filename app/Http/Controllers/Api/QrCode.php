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
    TaskEvent
};

class QrCode extends ApiController
{
    public function __construct(
        private UserJoinEvent $userJoinEvent,
        private TaskEventDetail $taskEventDetail,
        private TaskEvent $taskEvent
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, Request $request)
    {
    }

    public function qrEvent(EventRequest $request)
    {
        $data = [];
        try {
            $userId = $request->user()->id;
            $code = $request->input('code');
            $eventDetail = $this->taskEventDetail->whereCode($code)->first();
            $taskEvent = $this->taskEvent->findOrFail($eventDetail->task_event_id);
            $userJoinEvent = $this->userJoinEvent
                ->whereUserId($userId)
                ->whereTaskEventDetailId(optional($eventDetail)->id)
                ->first();

            if (!$eventDetail) {
                return $this->respondError('Job no found!');
            }

            if (!$userJoinEvent) {

                $this->userJoinEvent->create([
                    'user_id' => $userId,
                    'task_event_detail_id' => $eventDetail->id,
                    'task_id' => $taskEvent->task_id,
                    'task_event_id' => $eventDetail->task_event_id
                ]);
            }

            $data = [
                'task_id' => $taskEvent->task_id
            ];
        } catch (\Exception $e) {
            return $this->respondError('Errors');
        }

        return $this->respondWithData($data, 'Done');
    }
}
