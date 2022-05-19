<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

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
        $result = [];

        if (!$this->whenLoaded('participants') instanceof MissingValue
            && $this->resource->participants->isNotEmpty()
        ) {
            $userStatus = $this->resource->participants->first();
            if ($userId == $userStatus->user_id) {
                $result['user_status'] = $userStatus->toArray();
            }
        }

        return $this->resource->unsetRelation('participants')->toArray() + $result;
    }
}
