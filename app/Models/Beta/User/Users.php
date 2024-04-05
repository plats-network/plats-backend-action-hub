<?php

namespace App\Models\Beta\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Event\EventUserTicket;
use App\Models\Traits\Uuid;

class Users extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;
    use Uuid;

    protected $table = 'plats_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'fullname',
        'address',
        'birthday',
        'social',
        'active',
        'verify_code',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

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

}
