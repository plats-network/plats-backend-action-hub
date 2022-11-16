<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class TaskUser extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'task_id',
        'social_id',
        'location_id',
        'status', // 0: waiting, 1: processing, 2: completed, 3: cancel, 4: timeout, 5: reject
        'wallet_address',
        'location_checked',
        'time_left',
        'time_start',
        'time_end',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'user_id',
        'task_id',
        'social_id',
        'location_id',
        'deleted_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function taskLocations()
    {
        return $this->hasMany(TaskLocation::class, 'task_id', 'task_id');
    }

    public function getTimeLeftAttribute()
    {
        $time_left = Carbon::parse($this->attributes['time_left']);
        $now = Carbon::now();

        return $time_left && $now->lte($time_left) ? $time_left->timestamp : 0;
    }
}
