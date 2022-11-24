<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Branch;
use App\Helpers\{BaseImage, DateHelper};

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
        $isOpen = optional($this->user_task_reward)->is_open == 0 ? false : true;
        $openLabel = optional($this->user_task_reward)->is_consumed == 0 ? 'Unbox' : 'Opened';
        $icon = $isOpen ? BaseImage::loadImage($this->url_image) : BaseImage::loadImage();

        return [
            'id' => $this->id,
            'name' => $isOpen ? 'Box opened.' : 'Open the box now.',
            'icon'  => $icon,
            'expired_date'  => DateHelper::parseDate($this->end_at)->format('d/m/Y'),
            'expired_time'  => DateHelper::parseDate($this->end_at)->format('H:i'),
            'expired_timestamp'  => DateHelper::getTimestamp($this->end_at),
            'is_expired' => $isExpired,
            'is_use' => optional($this->user_task_reward)->is_consumed == 0 ? false : true,
            'is_use_label' => optional($this->user_task_reward)->is_consumed == 0 ? 'Not use' : 'used',
            'is_open' => $isOpen,
            'unbox_label' => optional($this->user_task_reward)->is_open == 0 ? 'Unbox' : 'Unboxed',
        ];
    }
}
