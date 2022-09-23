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
        $formatDate = date("Y-m-d H:i:s", $this->time_left);
        $time_start = Carbon::parse($formatDate)->subMinute($this->task->duration)->timestamp;

        return [
            "id" => $this->id,
            "time_left" => $this->time_left,
            "time_start" => $time_start,
            "time_current" => Carbon::now()->timestamp,
            "time_end" => $this->time_left,
            "wallet_address" => $this->wallet_address,
            "task" => $this->task,
            "task_locations" => $this->taskLocations()->first(),
        ];

        // return parent::toArray($request);
    }
}
