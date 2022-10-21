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
        $type_label = $this->getType($this->type);

        return [
            'id' => $this->id,
            'name' => 'Bonus',
            'icon'  => 'https://i.imgur.com/UuCaWFA.png',
            'amount' => $this->amount,
            'type' => (int) $this->type,
            'type_label' => $type_label,
        ];
    }

    /**
     * Get type
     *
     * @param $type
     * @return string
     */
    private function getType($type)
    {
        switch($type) {
            case 0:
                $type_label = 'token';
                break;
            case 1:
                $type_label = 'nft';
                break;
            case 2:
                $type_label = 'voucher';
                break;
            default:
                $type_label = 'card';
        }

        return $type_label;
    }
}

