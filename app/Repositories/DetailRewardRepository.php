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

    public function getRewards($userId, $type = null, $useFlag = false, $expired = false)
    {
        $now = Carbon::now();
        $data = $this->model
            ->with('branch:id,name,address')
            ->whereHas('user_task_reward', function(Builder $query) use ($userId, $type, $useFlag) {
                $query->whereUserId($userId)
                    ->whereIsConsumed($useFlag)
                    ->whereIsTray(true);
                // Nếu type = null: Lấy tất cả hiển thị ở hidden box
                if (!is_null($type)) {
                    // type = 0, 1, 2: Tokens, NFTs, Vouchers
                    $query->whereType($type);
                }
            });

        if ($expired == true) {
            $data->where('end_at', '<', $now);
        } else {
            $data->where('end_at', '>=', $now);
        }

        return $data;
    }

    public function getReward($userId, $detaiRewardId, $type = '')
    {
        return $this->model
            ->with('branch:id,address')
            ->whereHas('user_task_reward', function(Builder $query) use ($userId, $type) {
                if (is_null($type)) {
                    $query->whereUserId($userId);
                } else {
                    $query->whereUserId($userId)->whereType($type);
                }
            })
            ->whereId($detaiRewardId)
            ->firstOrFail();
    }

    public function getLockTray($userId)
    {
        $data = $this->model
            ->with('branch:id,name')
            ->whereHas('user_task_reward', function(Builder $query) use ($userId) {
                $query->whereUserId($userId)->whereIsTray(false);
            });

        return $data;
    }

    public function getDetail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getBoxs($userId, $unBoxFlag = false)
    {
        $data = $this->model
            ->with('branch:id,name,address')
            ->whereHas('user_task_reward', function(Builder $query) use ($userId, $unBoxFlag) {
                $query->whereUserId($userId)->whereIsOpen($unBoxFlag)->whereIsTray(true);
            });

        return $data;
    }
}
