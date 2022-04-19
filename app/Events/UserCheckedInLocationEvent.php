<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserCheckedInLocationEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * @var \App\Models\TaskUser
     */
    public $userLocation;

    /**
     * @var \App\Models\TaskLocation
     */
    public $taskLocation;

    /**
     * @var string
     */
    public $taskId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userLocation, $taskLocation, $taskId)
    {
        $this->userLocation = $userLocation;
        $this->taskLocation = $taskLocation;
        $this->taskId    = $taskId;
    }
}
