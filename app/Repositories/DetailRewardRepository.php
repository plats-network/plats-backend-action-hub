<?php

namespace App\Repositories;

use App\Models\DetailReward;
use App\Repositories\Concerns\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class DetailRewardRepository extends BaseRepository
{
    /**
     * 
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DetailReward::class;
    }

    public function getRewards($userId, $type = 0, $flag = false, $expired = false)
    {
        $now = Carbon::now();
        $date = Carbon::parse($now)->toDateString();

        $data = $this->model
            ->with('branch:id,name,address')
            ->whereHas('user_task_reward', function(Builder $query) use ($userId, $type, $flag) {
                $query->whereUserId($userId)->whereType($type);
                if ($flag == true) { $query->where('is_consumed', $flag); }
            });

        if ($expired == true) { $data->where('end_at', '<', $date); }

        return $data;
    }

    public function getReward($userId, $detaiRewardId, $type = 0)
    {
        return $this->model
            ->with('branch:id,address')
            ->whereHas('user_task_reward', function(Builder $query) use ($userId, $type) {
                $query->whereUserId($userId)->whereType($type);
            })
            ->whereId($detaiRewardId)
            ->firstOrFail();
    }

    public function getDetail($id)
    {
        return $this->model->findOrFail($id);
    }
}
