<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Branch;

class BoxResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $isExpired = is_null($this->end_at) ? true : Carbon::now() > $this->end_at;
        return [
            'id' => $this->id,
            'name' => 'Open the box now!',
            'icon'  => 'https://i.imgur.com/UuCaWFA.png',
            'expired'  => is_null($this->end_at) ? null : Carbon::parse($this->end_at)->format('d/m/Y'),
            'is_expired' => $isExpired,
            'unbox_label' => optional($this->user_task_reward)->is_consumed == 0 ? 'Unbox' : 'Unboxed',
            'is_unbox' => optional($this->user_task_reward)->is_consumed == 0 ? false : true
        ];
    }
}
