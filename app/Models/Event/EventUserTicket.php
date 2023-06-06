<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use App\Models\Traits\Uuid;

class EventUserTicket extends Model
{
    use HasFactory, Uuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_user_tickets';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name',
        'phone',
        'email',
        'task_id',
        'user_id',
        'type',
        'is_checkin',
        'hash_code',
        'sesion_code',
        'booth_code',
        'qr_image',
        'is_session',
        'is_booth',
        'color_session',
        'color_boot'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
