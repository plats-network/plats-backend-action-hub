<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Branch;

class LockTrayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'icon'  => $this->url_image,
            'is_status' => ($this->end_at && Carbon::now() > $this->end_at) ? true : false, // false: not open, true: open
            'time_stamp' => is_null($this->end_at) ? null : Carbon::parse($this->end_at)->timestamp,
            'time_origin' => is_null($this->end_at) ? null : Carbon::parse($this->end_at)->format('d-m-Y H:i:s'),
        ];
    }
}
