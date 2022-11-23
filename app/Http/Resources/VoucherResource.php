<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Branch;
use App\Helpers\{BaseImage, DateHelper};

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
        $conpany = Branch::findOrFail(optional($this->branch)->id)->company;
        $isOpen = optional($this->user_task_reward)->is_open == 0 ? false : true;

        $amount = $this->type == 0 ? optional($this->user_task_reward)->amount : $this->amount;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'amount' => $amount,
            'icon'  => BaseImage::loadImage($conpany->logo_path),
            'url_image' => BaseImage::loadImage($this->url_image),
            'description' => $this->description,
            'expired'  => DateHelper::parseDate($this->end_at)->format('d/m/Y'),
            'is_expired' => $is_expired,
            'from_time' => DateHelper::parseDate($this->start_at)->format('H:i'),
            'from_date' => DateHelper::parseDate($this->start_at)->format('d/m/Y'),
            'to_time' => DateHelper::parseDate($this->end_at)->format('H:i'),
            'to_date' => DateHelper::parseDate($this->end_at)->format('d/m/Y'),
            'address' => optional($this->branch)->address,
            'is_open' => $isOpen,
            'open_label' => $isOpen ? 'unbox' : 'box',
            'type' => optional($this->user_task_reward)->type,
            'type_label' => BaseImage::getType(optional($this->user_task_reward)->type),
        ];
    }
}
