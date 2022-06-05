<?php

namespace App\Listeners;

use App\Contracts\UserCompletedTask;
use App\Repositories\TaskRepository;
use App\Services\BLCGatewayService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ClaimRewardListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var \App\Repositories\TaskRepository
     */
    protected $taskRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Handle the event.
     *
     * @param \App\Contracts\UserCompletedTask $event
     *
     * @return void
     */
    public function handle(UserCompletedTask $event)
    {
        $task = $this->taskRepository->find($event->taskId());

        app(BLCGatewayService::class)->award($task->reward_amount, $task->id);
    }
}
