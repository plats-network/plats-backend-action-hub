<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $userId = $request->user()->id;
        $result = [];

        if (!$this->whenLoaded('participants') instanceof MissingValue
            && $this->resource->participants->isNotEmpty()
        ) {
            $userStatus = $this->resource->participants->first();
            if ($userId == $userStatus->user_id) {
                $result['user_status'] = $userStatus->toArray();
            }
        }
        $result['rewards'] = [
            [
                'reward_id' => '1', 
                'name' => 'PLATS Coin', 
                'description' => 'You can claim after 10days', 
                'amount' => '200',
                'unit' => 'Plats'
            ],
            [
                'reward_id' => '2', 
                'name' => 'Vouchers', 
                'description' => 'Discount 30% when using in 30 Shines', 
                'amount' => '2',
                'unit' => ''
            ],
            [
                'reward_id' => '3', 
                'name' => 'Gift cards', 
                'description' => 'Gift card 30k/use', 
                'amount' => '5',
                'unit' => ''
            ],
        ];
        return $this->resource->unsetRelation('participants')->toArray() + $result;
    }
}
