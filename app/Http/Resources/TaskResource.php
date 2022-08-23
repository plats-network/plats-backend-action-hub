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
                'name' => 'Mystery box.', 
                'description' => 'You can claim after 10 days', 
                'amount' => '1',
                'type' => '1',
                'image' => 'https://public.nftstatic.com/static/nft/zipped/8061c9dbe0d74430b53d904468d946d9_zipped.png'
            ]
        ];
        return $this->resource->unsetRelation('participants')->toArray() + $result;
    }
}
