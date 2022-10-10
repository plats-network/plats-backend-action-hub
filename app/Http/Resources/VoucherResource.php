<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Branch;

class VoucherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $is_expired = is_null($this->end_at) ? true : Carbon::now() > $this->end_at;
        $url_image = is_null($this->url_image) ? 'https://i.imgur.com/UuCaWFA.png' : $this->url_image;
        $conpany = Branch::findOrFail(optional($this->branch)->id)->company;
        $icon = is_null($conpany) ? 'icon' : $conpany->logo_path;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'icon'  => $icon,
            'url_image' => $url_image,
            'description' => $this->description,
            'expired'  => is_null($this->end_at) ? null : Carbon::parse($this->end_at)->format('d/m/Y'),
            'is_expired' => $is_expired,
            'from_time' => is_null($this->start_at) ? null : Carbon::parse($this->start_at)->format('H:i'),
            'from_date' => is_null($this->start_at) ? null : Carbon::parse($this->start_at)->format('d/m/Y'),
            'to_time' => is_null($this->end_at) ? null : Carbon::parse($this->end_at)->format('H:i'),
            'to_date' => is_null($this->end_at) ? null : Carbon::parse($this->end_at)->format('d/m/Y'),
            'address' => optional($this->branch)->address,
        ];
    }
}
