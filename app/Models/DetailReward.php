<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'branch_id',
        'reward_id',
        'type', // 0: token plats, 1: vouchers 30shine, 2: vouchers xem phim, 3: thẻ điện thoại...
        'name',
        'amount',
        'description',
        'url_image',
        'qr_code',
        'status',
        'start_at',
        'end_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'branch_id',
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
