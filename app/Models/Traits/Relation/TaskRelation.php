<?php

namespace App\Models\Traits\Relation;

use App\Models\{Group, TaskGallery, TaskGroup, TaskGuide, TaskLocation, TaskUser, Task, TaskSocial, User};

trait TaskRelation
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany(TaskUser::class, 'task_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany(TaskLocation::class, 'task_id', 'id')->orderBy('order')->orderBy('id')->with('taskLocationJobs');
    }

    public function groupTasks()
    {
        return $this->belongsToMany(Group::class, 'task_groups', 'group_id', 'task_id');

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function galleries()
    {
        return $this->hasMany(TaskGallery::class, 'task_id', 'id');
    }


    public function guides()
    {
        return $this->hasMany(TaskGuide::class, 'task_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rewards()
    {
        return $this->belongsToMany(Task::class);
    }

    /**
     * Get the task socials associated with the task.
     */
    public function taskSocials()
    {
        return $this->hasMany(TaskSocial::class, 'task_id', 'id');
    }
}
