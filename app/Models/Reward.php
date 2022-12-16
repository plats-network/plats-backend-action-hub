<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

/**
 * attrs
 * @property uuid $id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property integer $type
 * @property integer $region
 * @property date $start_at
 * @property date $end_at
 * @property datatime $created_at
 * @property datatime $updated_at
 */

class Reward extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rewards';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'type', // 0:  1:
        'region',
        'start_at',
        'end_at',
        'order',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'deleted_at',
    ];

    /**
     * Get the comments for the blog post.
     */
    public function detail_rewards()
    {
        return $this->hasMany(DetailReward::class);
    }

//    public function getImageAttribute()
//    {
//        return Storage::disk('s3')->url('icon/hidden_box.png');
//    }
}
