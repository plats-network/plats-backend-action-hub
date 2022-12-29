<?php

namespace App\Http\Resources;

use App\Helpers\DateHelper;
use App\Models\Reward;
use App\Models\TaskUser;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Http;

class TaskV2Resource extends JsonResource
{
    public function toArray($request)
    {
        $userId = $request->user()->id;
        $token = $request->user()->token;
        $creator = $this->getUserDetail($token, $this->creator_id);
        $dataTaskProgress = $this->getTaskImprogress($userId, $this->id);
        if (!$dataTaskProgress) {
            $task_improgress = null;
        } else {
            $formatDate = date("Y-m-d H:i:s", $dataTaskProgress->time_left);
            $time_start = Carbon::parse($formatDate)->subMinute($this->duration)->timestamp;
            $task_improgress = [
                'id'  => $dataTaskProgress->id,
                'status'  => $dataTaskProgress->status,
                'time_start'  => $time_start,
                'time_end'  => $dataTaskProgress->time_left
            ];
        }

        $task_done_number = $this->participants()
            ->where('user_id', $userId)
            ->where('status', USER_COMPLETED_TASK)
            ->count();

        // Số lượng check-in cần hoàn thành để done task
        $task_done = $task_done_number < $this->valid_amount ? false : true;
        $rewardLocation = $this->locations()->get()->toArray();
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
            'image'           => $this->image,
            'duration' => (int)$this->duration,
            'order'             => (int)$this->order,
            'valid_amount'      => (int)$this->valid_amount,
            'valid_radius'      => (int)$this->valid_radius,
            'distance'          => $this->distance,
            'deposit_status'    => $this->deposit_status,
            'type'              => $this->type,
            'created_at'        => DateHelper::getDateTime($this->created_at),
            'post_by' => $creator ? $creator['name'] : 'Plats Team',
            'improgress_flag'   => $task_improgress ? true : false,
            'task_done'         => $task_done,
            'task_improgress'   => $task_improgress,
            'task_done_number'  => $task_done_number,
            'rewards' => $rewardsConvert,
            'locations'         => $rewardLocation,
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
