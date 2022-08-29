<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskLocation extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task_locations';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'task_id',
        'name',
        'address',
        'long',
        'lat',
        'sort',
        'status',
        'phone_number',
        'open_time',
        'close_time',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'task_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'status',
    ];

    /**
     * @return string
     */
    public function getCoordinateAttribute()
    {
        return $this->long . ', ' . $this->lat;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function histories()
    {
        return $this->hasMany(TaskLocationHistory::class, 'location_id');
    }

    /**
     * Checkin guild
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function guides()
    {
        return $this->hasMany(TaskLocationGuide::class, 'location_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taskUser()
    {
        return $this->belongsTo(TaskUser::class, 'task_id');
    }
}
