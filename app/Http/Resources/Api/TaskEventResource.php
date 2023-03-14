<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\TaskEventDetailResource;

class TaskEventResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'banner_url' => $this->banner_url,
            'max_job' => $this->max_job,
            'type' => $this->type == 0 ? 'Session' : 'Booth',
            'jobs' => $this->detail->count() >= 0
                ? TaskEventDetailResource::collection($this->detail)
                : null
        ];

        return parent::toArray($request);
    }
}
