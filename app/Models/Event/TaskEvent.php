<?php

namespace App\Models\Event;

use App\Helpers\BaseImage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Task;
use App\Models\Traits\Uuid;

class TaskEvent extends Model
{
    use HasFactory, Uuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task_events';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'task_id',
        'name',
        'description',
        'banner_url',
        'type', // 0: Sesion, 1: Booth, 3: Hub
        'max_job',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function taskEventDetail()
    {
        return $this->hasMany(TaskEventDetail::class);
    }


    protected function bannerUrl(): Attribute
    {
        return Attribute::make(
            get: fn($value) => BaseImage::loadImage($value)
        );
    }
}
