<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Helpers\BaseImage;

class UnboxResource extends JsonResource
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
            'name' => 'Bonus',
            'icon'  => BaseImage::loadImage(),
            'amount' => $this->amount,
            'type' => (int) $this->type,
            'type_label' => BaseImage::getType($this->type),
        ];
    }
}
