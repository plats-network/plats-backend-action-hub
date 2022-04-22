<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
    use HasFactory;
    use Uuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task_users';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'task_id',
        'location_id',
        'started_at',
        'ended_at',
        'checkin_image',
        'activity_log',
    ];

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param $userId
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUser($builder, $userId)
    {
        return $builder->where('user_id', $userId);
    }
}
