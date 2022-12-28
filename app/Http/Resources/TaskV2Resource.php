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
        $rewards = Reward::where('id', '=', $this->taskRewards->reward_id)->first();
        $dataTaskProgress = $this->getTaskImprogress($userId, $this->id);
        if (!$dataTaskProgress) {
            $task_improgress = null;
        } else {
            $formatDate = date("Y-m-d H:i:s", $dataTaskProgress->time_left);
            $time_start = Carbon::parse($formatDate)->subMinute($this->duration)->timestamp;
            $task_improgress = [
                'id'  => $dataTaskProgress->id,
                'status'  => $dataTaskProgress->status,
                'time_left' => $dataTaskProgress->time_left,
                'time_current'  => Carbon::now()->timestamp,
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image'           => $this->image,
            'duration' => (int)$this->duration,
            'order'             => (int)$this->order,
            'valid_amount'      => (int)$this->valid_amount,
            'valid_radius'      => (int)$this->valid_radius,
            'rewards'           => $rewards,
            'distance'          => $this->distance,
            'deposit_status'    => $this->deposit_status,
            'type'              => $this->type,
            'created_at'        => DateHelper::getDateTime($this->created_at),
            'post_by' => $creator ? $creator['name'] : 'Plats Team',
            'locations'         => $this->locations()->get()->toArray(),
            'galleries'         => $this->guides()->get()->toArray(),
            'improgress_flag'   => $task_improgress ? true : false,
            'task_done'         => $task_done,
            'task_improgress'   => $task_improgress,
            'task_done_number'  => $task_done_number,
            'near'              => [
                'radius'        => (int)$this->valid_radius ?? 100,
                'units' => 'm',
            ],
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
}
