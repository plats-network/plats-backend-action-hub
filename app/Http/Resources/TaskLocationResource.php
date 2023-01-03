<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\{TaskLocationJobResource};

class TaskLocationResource extends JsonResource
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
            'amount' => $this->amount,
            'job_num' => $this->job_num,
            'jobs' => $this->taskLocationJobs->count() > 0 ?
                TaskLocationJobResource::collection($this->taskLocationJobs) :
                null
        ];
      }
}
