<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property uuid $id
 * @property uuid $branch_id
 * @property uuid $reward_id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $logo_path
 * @property datatime $created_at
 * @property datatime $updated_at
 */


// Bỏ đi ko dùng nữa 
class DetailReward extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detail_rewards';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'branch_id',
        'reward_id',
        'type', // 0: SP (plasts point), 1: NFTs, 2: Vouchers, 3: card mobile, 4: ticket film
        'name',
        'amount',
        'description',
        'url_image',
        'qr_code',
        'status', // false: disable, true: enable
        'start_at',
        'end_at',
        'proccess', // true: đã xử lý (cho user), false: chưa xử lý
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'branch_id',
        'reward_id',
    ];

    /**
     * Get the user that owns the phone.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the phone associated with the user.
     */
    public function user_task_reward()
    {
        return $this->hasOne(UserTaskReward::class);
    }
}
