<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use App\Helpers\{ActionHelper};
use Illuminate\Support\Facades\Http;
use App\Http\Resources\{TaskGuideResource};
use App\Models\{TaskUser};
use App\Models\User\UserTaskHistory;
use Illuminate\Support\Str;

class TaskSocialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $userId = optional($request->user())->id;
        $types = ActionHelper::commonType($this->platform, $this->type);
        $statusJob = UserTaskHistory::whereUserId($userId)
            ->whereTaskId($this->task_id)
            ->whereSourceId($this->id)
            ->count();

        return [
            'id' => $this->id,
            'reward_id' => $this->reward_id,
            'name' => $this->name,
            'description' => $this->description,
            'platform' => $this->platform,
            'platform_label' => $types['platform'],
            'type' => $this->type,
            'type_label' => $types['type'],
            'job_type' => 'social',
            'job_status' => $statusJob > 0 ? true : false,
            'url' => $this->url,
            'amount' => $this->amount,
            'lock' => $this->lock,
        ];


        // Old
        $start = false;
        $statusAction = false;
        $statusLabel = 'not_start_task';
        $userId = $request->user()->id;
        $userTask = TaskUser::whereUserId($userId)->whereTaskId($this->task_id);
        $amount = null;

        if ($userTask->count() > 0) {
            $userTaskWork = $userTask->whereSocialId($this->id)->first();
            $statusAction = optional($userTaskWork)->status == USER_COMPLETED_TASK ? true : false;
            $amount = optional($userTaskWork)->status == USER_COMPLETED_TASK ? $this->amount : null;
            $statusLabel = optional($userTaskWork)->status == USER_COMPLETED_TASK
                ? 'complete'
                : (optional($userTaskWork)->status == USER_PROCESSING_TASK ? 'processing' : 'waitting');
        }

        $text = $this->name . ' ' . $this->description;
        $textArrs = explode(' ', $text);
        $keys = [];
        foreach($textArrs as $txt) {
            if (Str::contains($txt, '#')) { $keys[] = $txt; }
        }

        $txtTag = '';
        if (count($keys) <= 0) {
            $txtTag = 'plats_network';
        } else {
            foreach($keys as $key => $value) {
                if ($key == count($keys) - 1) {
                    $txtTag = $txtTag . Str::replace('#', '', $value);
                } else {
                    $txtTag = $txtTag . Str::replace('#', '', $value) . ',';
                }
            }
        }

        return [
            'id' => $this->id,
            'task_id' => $this->task_id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => ActionHelper::getTypeStr($this->type)[0],
            'url' => $this->url,
            'url_intent' => ActionHelper::getUrlIntent($this->type, $this->url, $txtTag),
            'tbn_label' => ActionHelper::getTypeStr($this->type)[1],
            'start' => $start,
            'prize' => [
                'name' => 'PSP',
                'amount' => $amount
            ],
            'action' => [
                'status' => $statusAction,
                'label' => $statusLabel
            ],
            'icon' => ActionHelper::iconSocial($this->platform)
        ];
    }
}
