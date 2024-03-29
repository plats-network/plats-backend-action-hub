<?php

namespace App\Http\Resources\Api\Beta\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $creator = '';
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->banner_url,
            'type' => $this->type,
            'status' => $this->status,
            'post_by' => $creator ? $creator : 'Plats Team',
            'locations' => $this->taskLocations,
            'socials' => $this->taskSocials,
            'galleries' => $this->taskGalleries,
            'links' => $this->taskGenerateLinks,
        ];
    }
}
