<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskGenerateLinks extends Model
{
    use HasFactory, Uuid;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task_generate_links';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'task_id',
        'name',
        'type',
        'url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
