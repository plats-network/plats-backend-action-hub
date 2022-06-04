<?php

namespace App\Listeners;

use App\Contracts\UserCompletedTask;
use App\Repositories\TaskRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

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

        $gatewayUrl = config('blc.connection.host') . ':' . config('blc.connection.port');
        $actionUrl  = $gatewayUrl . '/reward/award';
        $query      = [
            'task_id' => 0,
            'amount'  => $task->reward_amount,
            //'address' => ''
        ];

        Http::get($actionUrl, $query);
    }
}
