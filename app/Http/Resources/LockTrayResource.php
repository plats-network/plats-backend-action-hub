<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Branch;
use App\Helpers\{BaseImage, DateHelper};

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
            'name' => '1 Boxes đã đến ngày được mở',
            'icon'  => BaseImage::loadImage(),
            'is_status' => ($this->end_at && Carbon::now() > $this->end_at) ? true : false, // false: not open, true: open
            'time_stamp' => DateHelper::getTimestamp($this->end_at),
            'time_origin' => DateHelper::parseDate($this->end_at)->format('d-m-Y H:i:s'),
        ];
    }
}
