<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'birth',
        'gender',
        'avatar_path',
        'password',
        'role',
        'twitter',
        'facebook',
        'discord',
        'telegram',
        'email_verified_at',
        'confirmation_code'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'check_avatar',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getAvatarPathAttribute()
    {
        return $this->attributes['avatar_path'] ? $this->attributes['avatar_path'] : 'https://lumiere-a.akamaihd.net/v1/images/nt_avatarmcfarlanecomic-con_223_01_2deace02.jpeg';
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return $this->attributesToArray();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function providers()
    {
        return $this->hasOne(Provider::class, 'user_id', 'id');
    }

    /**
     * @return string
     */
    public function getBirthAttribute($birth)
    {
        if (is_null($this->attributes['birth'])) {
            return null;
        }

        return Carbon::parse($this->attributes['birth'])->format('d/m/Y');
    }

}
