<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property uuid $id
 * @property uuid $company_id
 * @property string $logo_path
 * @property string $address
 * @property string $phone
 * @property string $hotline
 * @property date $open_time
 * @property date $close_time
 * @property datatime $created_at
 * @property datatime $updated_at
 */

class Branch extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'branches';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'company_id',
        'name',
        'logo_path',
        'address',
        'phone',
        'hotline',
        'open_time',
        'close_time',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'company_id',
    ];

    /**
     * Get the branch that owns the company.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
