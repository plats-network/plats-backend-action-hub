<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TaskDogingResource extends JsonResource
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
            "id" => $this->id,
            "time_left" => $this->time_left,
            "duration"  => $this->task()->first()->duration,
            "time_start" => Carbon::parse($this->time_start)->timestamp,
            "time_end" => Carbon::parse($this->time_end)->timestamp,
            "time_start_orginal" => Carbon::parse($this->time_start)->format('Y-m-d H:i:s'),
            "time_end_orginal" => Carbon::parse($this->time_end)->format('Y-m-d H:i:s'),
            "wallet_address" => $this->wallet_address,
            "task" => $this->task,
            "task_locations" => $this->taskLocations()->first(),
        ];

        // return parent::toArray($request);
    }
}
