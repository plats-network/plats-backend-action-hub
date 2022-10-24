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

    public function getRewards($userId, $type = 0, $useFlag = false, $expired = false)
    {
        $now = Carbon::now();
        $data = $this->model
            ->with('branch:id,name,address')
            ->whereHas('user_task_reward', function(Builder $query) use ($userId, $type, $useFlag) {
                $query->whereUserId($userId)
                    ->whereIsConsumed($useFlag)
                    ->whereType($type)
                    ->whereIsTray(true);
                $query->orderBy('updated_at', 'DESC');
            });

        if ($expired == true) {
            $data->where('end_at', '<', $now);
        } else {
            $data->where('end_at', '>=', $now);
        }

        return $data;
    }

    public function getGiftExp($userId) # getVoucherExp
    {
        $now = Carbon::now();
        $data = $this->model
            ->with('branch:id,name,address')
            ->whereHas('user_task_reward', function(Builder $query) use ($userId) {
                $query->whereUserId($userId)
                    ->whereIn('type', [2, 3])
                    ->whereIsTray(true);
            });

        $data->where('end_at', '<', $now)->orderBy('updated_at', 'DESC');

        return $data;
    }

    public function getGifts($userId) # getVouchers
    {
        // $now = Carbon::now();
        $data = $this->model
            ->with('branch:id,name,address')
            ->whereHas('user_task_reward', function(Builder $query) use ($userId) {
                $query->where(function($q1) use ($userId) {
                    $q1->whereUserId($userId)
                        ->whereIn('type', [0,1,2,3])
                        ->whereIsOpen(false);
                })
                ->orWhere(function($q2) use ($userId) {
                    $q2->whereUserId($userId)
                        ->whereIn('type', [2,3])
                        ->whereIn('is_open', [false, true]);
                })
                ->whereUserId($userId)
                ->whereIsTray(true)
                ->whereIsConsumed(false);
            });

        $data->orderBy('updated_at', 'DESC');

        return $data;
    }

    public function getGiftUses($userId) # getVoucherUses
    {
        $now = Carbon::now();
        $data = $this->model
            ->with('branch:id,name,address')
            ->whereHas('user_task_reward', function(Builder $query) use ($userId, $type) {
                $query->whereUserId($userId)
                    ->whereIn('type', [2, 3])
                    ->whereIsTray(true)
                    ->whereIsConsumed(true);
            });
        $data->orderBy('updated_at', 'DESC');

        return $data;
    }

    public function getReward($userId, $detaiRewardId, $type = '')
    {
        return $this->model
            ->with('branch:id,address')
            ->whereHas('user_task_reward', function(Builder $query) use ($userId, $type) {
                $query->whereUserId($userId);
            })
            ->whereId($detaiRewardId)
            ->firstOrFail();
    }

    public function getLockTray($userId)
    {
        $data = $this->model
            ->with('branch:id,name')
            ->whereHas('user_task_reward', function(Builder $query) use ($userId) {
                $query->whereUserId($userId)
                    ->whereIsTray(false)
                    ->orderBy('updated_at', 'DESC');
            })
            ->orderBy('updated_at', 'DESC');

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
                $query->whereUserId($userId)
                    ->whereIsOpen($unBoxFlag)
                    ->whereIsTray(true);
            })
            ->orderBy('updated_at', 'DESC');

        return $data;
    }

    public function getNftTokens($userId, $type = 0)
    {
        $data = $this->model
            ->with('branch:id,name,address')
            ->whereHas('user_task_reward', function(Builder $query) use ($userId, $type) {
                $query->whereUserId($userId)
                    ->whereType($type)
                    ->whereIsOpen(true)
                    ->whereIsTray(true);
            })
            ->orderBy('updated_at', 'DESC');

        return $data;
    }
}
