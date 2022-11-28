<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Reward;
use Carbon\Carbon;

class CheckInResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        unset($request);

        $result = $this->resource->toArray();
        $result['reward'] = Reward::where('end_at', '>=', Carbon::now())->first();

        return $result;
    }
}
