<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use App\Helpers\DateHelper;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\TaskGuideResource;

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
        return [
            'id' => $this->id,
            'task_id' => $this->task_id,
            'name' => $this->name,
            'type' => $this->type,
            'url' => $this->url,
            'platform' => $this->platform
        ];
    }
}
