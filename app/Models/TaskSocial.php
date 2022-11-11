<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskSocial extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task_socials';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'task_id',
        'type',
        'url',
        'platform'
    ];
    
    /**
     * Get the task that owns the task social.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    
    /**
     * Get the task social results associated with the task social.
     */
    public function taskSocialResults()
    {
        return $this->hasOne(TaskSocialResult::class);
    }
}
