<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use App\Helpers\DateHelper;
use Illuminate\Support\Facades\Http;
use App\Models\{TaskUser, Reward};
use Carbon\Carbon;
use App\Http\Resources\TaskGuideResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $creator = $this->getUserDetail($this->creator_id);
        $userId = $request->user()->id;
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
        $rewards = Reward::where('end_at', '>=', Carbon::now())->first();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'duration' => (int)$this->duration,
            'order'             => (int)$this->order,
            'valid_amount'      => (int)$this->valid_amount,
            'valid_radius'      => (int)$this->valid_radius,
            'distance'          => $this->distance,
            'deposit_status'    => $this->deposit_status,
            'type'              => $this->type,
            'created_at'        => DateHelper::getDateTime($this->created_at),
            'cover_url'         => $this->cover_url,
            'creator_id'        => $creator ? $creator['id'] : '',
            'creator_name'      => $creator ? $creator['name'] : '',
            'improgress_flag'   => $task_improgress ? true : false,
            'task_done'         => $task_done,
            'task_improgress'   => $task_improgress,
            'task_done_number'  => $task_done_number,
            'near'              => [
                'radius'        => (int)$this->valid_radius ?? 100,
                'units' => 'm',
            ],
            'locations'         => $this->locations()->get()->toArray(),
            'socials'           => $this->taskSocials()->get()->toArray(),
            'galleries'         => GalleryResource::collection($this->galleries()->get()),
            'guide'             => new TaskGuideResource($this->task_guides),
            'rewards'           => $rewards,
        ];
    }

    /**
     * Retrieve a user by userId
     *
     * @param $userId
     *
     */
    protected function getUserDetail($userId)
    {
        try {
            $url = config('app.api_user_url') . '/api/profile/' . $userId;
            $response = Http::withToken(request()->bearerToken())->get($url);
        } catch (ModelNotFoundException $e) {
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
