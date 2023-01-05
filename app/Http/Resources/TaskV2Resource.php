<?php

namespace App\Http\Resources;

use App\Helpers\DateHelper;
use App\Models\Reward;
use App\Models\TaskUser;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Http;

class TaskV2Resource extends JsonResource
{
    public function toArray($request)
    {
        $token = $request->user()->token;
        $creator = $this->getUserDetail($token, $this->creator_id);
        $rewardLocation = $this->locations()->get()->toArray();
        $groupTasks = $this->groupTasks()->get()->toArray();
        $rewardSocials = $this->taskSocials()->get()->toArray();
        $rewards = array_merge($rewardLocation,$rewardSocials);
        $idReward = [];
        foreach ($rewards as $reward) {
            $idReward[] = [
                'id' => $reward['reward_id'],
                'amount' => (int)$reward['amount'],
            ];
        }
        $rewardsConvert= $this->convert($idReward);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image'           => $this->banner_url ,
            'order'             => (int)$this->order,
            'type'              => $this->type,
            'created_at'        => DateHelper::getDateTime($this->created_at),
            'post_by' => $creator ? $creator['name'] : 'Plats Team',
            'rewards' => $rewardsConvert,
            'locations'         => $rewardLocation,
            'group'         => $groupTasks,
            'galleries'         => $this->galleries()->get()->toArray(),
            'socials'           => $rewardSocials,
        ];
    }

    protected function getUserDetail($token, $userId)
    {
        try {
            $url = config('app.api_user_url') . '/api/cws/' . $userId;
            $response = Http::withToken($token)->get($url);
        } catch (\Exception $e) {
            return null;
        }

        return $response->json('data') ?? null;
    }

    protected function getTaskImprogress($userId, $taskId)
    {
        try {
            return TaskUser::where('user_id', $userId)
                ->where('task_id', $taskId)
                ->where('status', USER_PROCESSING_TASK)
                ->first();
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }
    protected function convert($idReward){
        $result = array();

        $names = array_column($idReward, 'id');
        $QTYs  = array_column($idReward, 'amount');

        $unique_names = array_unique($names);

        foreach ($unique_names as $name){
            $this_keys = array_keys($names, $name);
            $qty = array_sum(array_intersect_key($QTYs, array_combine($this_keys, $this_keys)));
            $image = Reward::where('id',$name)->first();
            $result[] = [
                "image"=> isset($image) ? $image->image : null,
                "amount"=>$qty
            ];
        }
        return $result;
    }
}
