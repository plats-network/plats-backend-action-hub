<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTaskReward extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_task_rewards';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'detail_reward_id',
        'type', // 0: tokens, 1: NFTs, 2: Vouchers, 3: boxs, 4: Wallet
        'amount',
        'is_consumed', // false: chưa nhận, true: đã nhận
        'consume_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'user_id',
        'deleted_at',
        'detail_reward_id',
    ];

    /**
     * Get the user that owns the phone.
     */
    public function detail_reward()
    {
        return $this->belongsTo(Branch::class, 'detail_reward_id', 'id');
    }
}
