<?php

namespace App\Models;

use App\Models\Traits\Attribute\TaskAttribute;
use App\Models\Traits\Method\TaskMethod;
use App\Models\Traits\Relation\TaskRelation;
use App\Models\Traits\Scope\TaskScope;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Task extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;
    use TaskRelation, TaskScope, TaskAttribute, TaskMethod;

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
        'duration',// Minute
        'distance',//KM
        'total_reward',
        'deposit_status',
        'type',
        'creator_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'total_reward',
        'image',
        'status',
        'creator_id',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['cover_url'];
}
