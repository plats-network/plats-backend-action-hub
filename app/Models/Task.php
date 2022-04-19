<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'duration',// Minute
        'distance',//KM
        'reward_amount',
        'type',
        'creator_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at'
    ];

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string $localId Location ID
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasLocation($builder, $localId)
    {
        return $builder->whereHas('locations', function ($q) use ($localId) {
            $q->where('id', $localId);
        });
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string $localId Location ID
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithLocation($builder, $localId)
    {
        return $builder->with(['locations' => function ($q) use ($localId) {
            return $q->where('id', $localId);
        }]);
    }

    public function participants()
    {
        return $this->hasMany(TaskUser::class, 'task_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany(TaskLocation::class, 'task_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function galleries()
    {
        return $this->hasMany(TaskGallery::class, 'task_id', 'id');
    }
}
