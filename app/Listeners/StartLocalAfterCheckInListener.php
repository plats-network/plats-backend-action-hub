<?php

namespace App\Listeners;

use App\Events\UserCheckedInLocationEvent;
use App\Services\TaskService;
use Illuminate\Contracts\Queue\ShouldQueue;

class StartLocalAfterCheckInListener implements ShouldQueue
{
    /**
     * @var \App\Services\TaskService
     */
    protected $taskService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Handle the event.
     *
     * @param UserCheckedInLocationEvent $event
     *
     * @return bool
     */
    public function handle(UserCheckedInLocationEvent $event)
    {
        $taskId = $event->taskId;
        //Find tak and all locations
        $task = $this->taskService->find($taskId, ['locations']);

        //User just checked in at this location
        $eventCheckedLocal = $event->userLocation;
        // Get user id from history check-in
        $userId = $eventCheckedLocal->user_id;

        // Get history checkin of User
        $userStartedLocations = $this->taskService->myLocations($event->taskId, $userId);

        $nextLocation = $task->locations->whereNotIn('id', $userStartedLocations->pluck('location_id'))->first();
        if (is_null($nextLocation)) {
            return true;
        }

        try {
            $this->taskService->startTask($taskId, $nextLocation->id, $userId);
        } catch (\Throwable $e) {
            return true;
        }

        return true;
    }
}
