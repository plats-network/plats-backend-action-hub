<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use App\Helpers\{DateHelper, ActionHelper, BaseImage};
use Illuminate\Support\Facades\Http;
use App\Models\{
    TaskUser, Reward, UserTaskAction,
    TaskGroup, Group
};
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
        $groups = $this->groupTasks->count() > 0 ? TaskGroupResource::collection($this->groupTasks) : null;
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
            'groups' => $groups,
            'task_checkin' => $this->taskLocations->count() > 0 ? TaskLocationResource::collection($this->taskLocations) : null,
            'task_socials' => $this->taskSocials->count() > 0 ? TaskSocialResource::collection($this->taskSocials) : null,
        ];
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
