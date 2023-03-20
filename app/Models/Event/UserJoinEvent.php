<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event\TaskEvent;
use App\Models\Task;
use App\Models\Traits\Uuid;

class UserJoinEvent extends Model
{
    use HasFactory, Uuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_join_events';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'user_id',
        'task_event_detail_id',
        'agent',
        'ip_address',
        'task_id',
        'task_event_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    public function task_event()
    {
        return $this->belongsTo(TaskEvent::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
