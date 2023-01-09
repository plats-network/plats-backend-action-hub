<?php

namespace App\Http\Resources\Admin;

use App\Helpers\BaseImage;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'task_id' => $this->task_id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'max_job' => $this->max_job,
            'status' => $this->status,
            'banner_url' => BaseImage::imgGroup($this->banner_url),
        ];
    }
}
