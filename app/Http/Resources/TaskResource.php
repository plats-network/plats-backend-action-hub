<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Facades\Http;

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
        // Get creator task user
        $creator = $this->getUserDetail($this->creator_id);;
        $result['creator_id'] = $creator['id'];
        $result['creator_name'] = $creator['name'];

        // Get rewards task user
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

    /**
     * Retrieve a user by userId
     *
     * @param $userId
     *
     */
    public function getUserDetail($userId)
    {
        $url = config('app.api_user_url') . '/profile/' . $userId;
        $response = Http::withToken(request()->bearerToken())->get($url);

        return $response->json('data') ?? null;
    }
}
