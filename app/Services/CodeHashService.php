<?php

namespace App\Services;

use App\Models\Event\{TaskEvent, UserJoinEvent, EventUserTicket};

class CodeHashService
{
    /**
     * @param ResetPasswordRepository $repository
     */
    public function __construct(
        private TaskEvent $taskEvent,
        private UserJoinEvent $userJoinEvent,
        private EventUserTicket $eventUserTicket
    ) {
        $this->taskEvent = $taskEvent;
        $this->userJoinEvent = $userJoinEvent;
    }

    public function makeCode($taskId, $userId)
    {
        $session = $this->taskEvent->whereTaskId($taskId)->whereType(0)->first();
        $booth = $this->taskEvent->whereTaskId($taskId)->whereType(1)->first();
        $eventUserTicket = $this->eventUserTicket->whereTaskId($taskId)->whereUserId($userId)->first();
        $countMaxSession = $this->userJoinEvent->whereTaskEventId($session->id)->whereUserId($userId)->count();
        $countMaxBooth = $this->userJoinEvent->whereTaskEventId($booth->id)->whereUserId($userId)->count();

        if ($booth) {
            $maxBooth = $booth->max_job;
            if (
                $eventUserTicket
                && empty($eventUserTicket->booth_code)
                && $countMaxBooth >= $maxBooth
            ) {
                $maxCode = (int) $this->eventUserTicket->max('booth_code');
                $eventUserTicket->update([
                    'booth_code' => $maxCode + 1,
                    'color_boot' => '#' . substr(md5(rand()), 0, 6)
                ]);
            }
        }

        if ($session) {
            $maxSession = $session->max_job;

            if (
                $eventUserTicket
                && empty($eventUserTicket->sesion_code)
                && $countMaxSession >= $maxSession
            ) {
                $maxCode = (int) $this->eventUserTicket->max('sesion_code');
                $eventUserTicket->update([
                    'sesion_code' => $maxCode + 1,
                    'color_session' => '#' . substr(md5(rand()), 0, 6)
                ]);
            }
        }

        return true;
    }
}
