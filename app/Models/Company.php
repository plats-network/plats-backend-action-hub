<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * attrs
 * @property uuid $id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $logo_path
 * @property datatime $created_at
 * @property datatime $updated_at
 */

class Company extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'address',
        'phone',
        'hotline',
        'logo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * Get the comments for the blog post.
     */
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}
