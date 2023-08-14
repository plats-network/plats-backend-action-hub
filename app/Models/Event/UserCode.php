<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuid;

class UserCode extends Model
{
    use HasFactory, Uuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'user_id',
        'task_id',
        'number_code', // Mã nhận thưởng
        'hash_code', // Mã màu,
        'travel_game_id', // Travel game
        'status', // Thạng thái nhận thưởng
        'type', // 0: Session, 1: Booth
    ];
}
