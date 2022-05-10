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
        unset($request);

        $result = $this->resource->unsetRelation('participants')->toArray();

        if (!$this->resource->participants instanceof MissingValue
            && $this->resource->participants->isNotEmpty()
        ) {
            $userStatus = $this->resource->participants->first();
            $result['user_status'] = $userStatus->toArray();
        }

        return $result;
    }
}
