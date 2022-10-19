<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuid;

class CodeVoucher extends Model
{
    use HasFactory, Uuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'code_vouchers';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['type', 'code', 'status'];
}
