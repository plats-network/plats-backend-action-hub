<?php

namespace App\Models;

use App\Helpers\BaseImage;
use App\Models\Traits\Attribute\TaskAttribute;
use App\Models\Traits\Method\TaskMethod;
use App\Models\Traits\Relation\TaskRelation;
use App\Models\Traits\Scope\TaskScope;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Task extends Model
{
    use HasFactory, Uuid, SoftDeletes, TaskRelation, TaskScope, TaskAttribute, TaskMethod;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'duration', // Minute
        'order',
        'total_reward',
        'valid_amount',
        'valid_radius',
        'deposit_status',
        'type',
        'creator_id',
        'status',
        'checkin_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['cover_url'];

    /**
     * Get the task_guides for the tasks.
     */
    public function task_guides()
    {
        return $this->hasMany(TaskGuide::class)
            ->whereStatus(true)
            ->latest();
    }

    public function taskRewards()
    {
        return $this->hasOne(TaskReward::class,'task_id');
    }

    public function taskLocation()
    {
        return $this->hasMany(TaskLocation::class,'task_id');
    }

    public function taskSocial()
    {
        return $this->hasMany(TaskSocial::class,'task_id');
    }

    public function taskGuides()
    {
        return $this->hasMany(TaskGuide::class,'task_id');
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => BaseImage::loadImage($value)
        );
    }
}
