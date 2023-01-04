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
        'banner_url',
        'start_at',
        'end_at',
        'order',
        'status',
        'type',
        'creator_id',
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
    public function taskGuides()
    {
        return $this->hasMany(TaskGuide::class);
    }

    public function groupTasks(){
        return $this->belongsToMany(Group::class,'task_groups','task_id','group_id')->withTimestamps();

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taskLocations()
    {
        return $this->hasMany(TaskLocation::class)->with('taskLocationJobs');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taskSocials()
    {
        return $this->hasMany(TaskSocial::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taskGalleries()
    {
        return $this->hasMany(TaskGallery::class);
    }

    protected function bannerUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => BaseImage::loadImage($value)
        );
    }
}
