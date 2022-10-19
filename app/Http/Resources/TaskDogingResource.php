<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Task;

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
        $task = Task::find($this->task_id);

        return [
            "id" => $this->id,
            "time_left" => $this->time_left,
            "duration"  => $this->task()->first()->duration,
            "time_start" => Carbon::parse($this->time_start)->timestamp,
            "time_end" => Carbon::parse($this->time_end)->timestamp,
            "time_start_orginal" => Carbon::parse($this->time_start)->format('Y-m-d H:i:s'),
            "time_end_orginal" => Carbon::parse($this->time_end)->format('Y-m-d H:i:s'),
            "wallet_address" => $this->wallet_address,
            "time_expried"  => Carbon::parse($this->time_end) > Carbon::now() ? false : true,
            'near' => [
                'radius' => (int)$this->task()->first()->valid_radius ?? 100,
                'units' => 'm',
            ],
            "task" => [
                'id' => optional($task)->id,
                'name' => optional($task)->name,
                'cover_url' => optional($task)->cover_url,
            ],
            "task_locations" => $this->taskLocations()->first(),
        ];
    }
}
