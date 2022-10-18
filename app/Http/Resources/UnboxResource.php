<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

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
        $type_label = $this->type == 0 ? "token" : ($this->type == 1 ? 'nft' : 'voucher');

        return [
            'id' => $this->id,
            'name' => 'Bonus',
            'icon'  => 'https://i.imgur.com/UuCaWFA.png',
            'amount' => $this->amount,
            'type' => $this->type,
            'type_label' => $type_label,
        ];
    }
}

