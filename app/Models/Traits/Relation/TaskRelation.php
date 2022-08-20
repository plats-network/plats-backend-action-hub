<?php 

namespace App\Models\Traits\Relation;

use App\Models\{TaskGallery, TaskLocation, TaskUser, Task};

trait TaskRelation {
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
        return $this->hasMany(TaskLocation::class, 'task_id', 'id')->orderBy('sort')->orderBy('id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function galleries()
    {
        return $this->hasMany(TaskGallery::class, 'task_id', 'id');
    }
    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rewards()
    {
        return $this->belongsToMany(Task::class);
    }
}