<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuid;

class UserSponsor extends Model
{
    use HasFactory, Uuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_sponsors';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'user_id',
        'task_id',
        'sponsor_id',
        'sponsor_detail_id',
        'amount',
        'note',
    ];
}
