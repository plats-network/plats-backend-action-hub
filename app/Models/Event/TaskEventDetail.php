<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event\TaskEvent;
use App\Models\Traits\Uuid;

class TaskEventDetail extends Model
{
    use HasFactory, Uuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task_event_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'task_event_id',
        'travel_game_id',
        'name',
        'description',
        'status',
        'code',
        'is_required',
        'is_question',
        'nft_link',
        'sort',
        'question',
        'a1', 'a2', 'a3', 'a4',
        'is_a1', 'is_a2', 'is_a3', 'is_a4',
    ];
}
