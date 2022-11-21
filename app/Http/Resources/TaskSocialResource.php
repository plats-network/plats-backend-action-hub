<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use App\Helpers\{ActionHelper};
use Illuminate\Support\Facades\Http;
use App\Http\Resources\{TaskGuideResource};
use App\Models\{TaskUser};

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
        $start = false;
        $statusAction = false;
        $statusLabel = 'not_start_task';
        $userId = $request->user()->id;
        $userTask = TaskUser::whereUserId($userId)->whereTaskId($this->task_id);

        if ($userTask->count() > 0) {
            $userTaskWork = $userTask->whereSocialId($this->id)->first();

            if (!$userTaskWork) {
                TaskUser::create([
                    'user_id' => $userId,
                    'task_id' => $this->task_id,
                    'social_id' => $this->id,
                    'status' => USER_PROCESSING_TASK
                ]);
            }

            $statusAction = $userTaskWork->status == USER_COMPLETED_TASK ? true : false;
            $statusLabel = $userTaskWork->status == USER_COMPLETED_TASK
                ? 'complete'
                : ($userTaskWork->status == USER_PROCESSING_TASK ? 'processing' : 'waitting');
        }

        return [
            'id' => $this->id,
            'task_id' => $this->task_id,
            'name' => $this->name,
            'type' => ActionHelper::getTypeStr($this->type),
            'url' => $this->url,
            'start' => $start,
            'action' => [
                'status' => $statusAction,
                'label' => $statusLabel
            ],
            'icon' => ActionHelper::iconSocial($this->platform)
        ];
    }
}
