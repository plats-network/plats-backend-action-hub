<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use App\Helpers\{DateHelper, ActionHelper};
use Illuminate\Support\Facades\Http;
use App\Models\{TaskUser, Reward, UserTaskAction};
use Carbon\Carbon;

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
        $userId = $request->user()->id;
        $token = $request->user()->token;
        $likeCount = UserTaskAction::whereUserId($userId)->whereTaskId($this->id)->whereType(TASK_LIKE)->count();
        $pinCount = UserTaskAction::whereUserId($userId)->whereTaskId($this->id)->whereType(TASK_PIN)->count();
        $checkTaskStart = TaskUser::whereUserId($userId)->whereTaskId($this->id)->whereStatus(0)->count();
        $creator = null; //$this->getUserDetail($token, $this->creator_id); TODO

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'banner_url' => $this->banner_url,
            'post_by' => $creator ? $creator['name'] : 'Plats Team',
            'start_at' => DateHelper::getDateTime($this->start_at),
            'end_at' => DateHelper::getDateTime($this->end_at),
            'task_start' => $checkTaskStart > 0 ? true : false,
            'like' => [
                'is_like' => $likeCount > 0 ? true : false,
                'type_like' => $likeCount > 0 ? 'like' : 'unlike'
            ],
            'pin' => [
                'is_pin' => $pinCount > 0 ? true : false,
                'type_pin' => $pinCount > 0 ? 'pin' : 'unpin',
            ],
            'task_checkin' => $this->taskLocations->count() > 0 ? TaskLocationResource::collection($this->taskLocations) : null,
            'task_socials' => $this->taskSocials->count() > 0 ? TaskSocialResource::collection($this->taskSocials) : null,
        ];

        // OLD
        // $userId = $request->user()->id;
        // $token = $request->user()->token;
        // $creator = $this->getUserDetail($token, $this->creator_id);
        // $dataTaskProgress = $this->getTaskImprogress($userId, $this->id);

        // if (!$dataTaskProgress) {
        //   $task_improgress = null;
        // } else {
        //   $formatDate = date("Y-m-d H:i:s", $dataTaskProgress->time_left);
        //   $time_start = Carbon::parse($formatDate)->subMinute($this->duration)->timestamp;
        //   $task_improgress = [
        //     'id'  => $dataTaskProgress->id,
        //     'status'  => $dataTaskProgress->status,
        //     'time_left' => $dataTaskProgress->time_left,
        //     'time_current'  => Carbon::now()->timestamp,
        //     'time_start'  => $time_start,
        //     'time_end'  => $dataTaskProgress->time_left
        //   ];
        // }

        // $task_done_number = $this->participants()
        //     ->where('user_id', $userId)
        //     ->where('status', USER_COMPLETED_TASK)
        //     ->count();

        // // Số lượng check-in cần hoàn thành để done task
        // $task_done = $task_done_number < $this->valid_amount ? false : true;
        // $rewards = Reward::where('end_at', '>=', Carbon::now())->first();

        // return [
        //     'id' => $this->id,
        //     'name' => $this->name,
        //     'description' => $this->description,
        //     'duration' => (int)$this->duration,
        //     'order'             => (int)$this->order,
        //     'valid_amount'      => (int)$this->valid_amount,
        //     'valid_radius'      => (int)$this->valid_radius,
        //     'distance'          => $this->distance,
        //     'deposit_status'    => $this->deposit_status,
        //     'type'              => $this->type,
        //     'created_at'        => DateHelper::getDateTime($this->created_at),
        //     'cover_url'         => $this->cover_url,
        //     'post_by' => $creator ? $creator['name'] : 'Plats Team',
        //     'improgress_flag'   => $task_improgress ? true : false,
        //     'task_done'         => $task_done,
        //     'task_improgress'   => $task_improgress,
        //     'task_done_number'  => $task_done_number,
        //     'near'              => [
        //         'radius'        => (int)$this->valid_radius ?? 100,
        //         'units' => 'm',
        //     ],
        //     'locations'         => $this->locations()->get()->toArray(),
        //     'galleries'         => GalleryResource::collection($this->galleries()->get()),
        //     'guide'             => new TaskGuideResource($this->task_guides),
        //     'rewards'           => $rewards,
        // ];
    }

    /**
     * Retrieve a user by userId
     *
     * @param $userId
     *
     */
    protected function getUserDetail($token, $userId)
    {
        try {
            $url = config('app.api_user_url') . '/api/profile/' . $userId;
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
