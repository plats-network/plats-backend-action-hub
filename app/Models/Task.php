<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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
        'image',
        'status',
        'creator_id',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['cover_url'];

    /**
     * @return string
     */
    public function getCoverUrlAttribute()
    {
        if (is_null($this->image)) {
            return 'https://via.placeholder.com/250x130?text=Cover Image';
        }

        return Storage::url($this->image);
    }

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

    /**
     * @param $userId
     *
     * @return \App\Models\Task|m.\App\Models\Task.load
     */
    public function scopeWithUserStatus($userId)
    {
        return $this->load(['participants' => function ($q) use ($userId) {
            return $q->where('user_id', $userId);
        } ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany(TaskUser::class, 'task_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany(TaskLocation::class, 'task_id', 'id')->orderBy('sort')->orderBy('id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function galleries()
    {
        return $this->hasMany(TaskGallery::class, 'task_id', 'id');
    }
}
