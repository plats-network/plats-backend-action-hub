<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Branch;
use App\Helpers\{BaseImage, DateHelper};

class GroupResource extends JsonResource
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
            'name' => (string)$this->name,
            'name_en' => (string)$this->name_en,
            'username' => (string)$this->username,
            'country' => (string)$this->country,
            'desc_vn' => (string)$this->desc_vn,
            'desc_en' => (string)$this->desc_en,
            'avatar_url' => (string)$this->avatar_url,
            'headline' => (string)$this->headline,
            'cover_url' => (string)$this->cover_url,
            'site_url' => (string) $this->site_url,
            'twitter_url' => (string)$this->twitter_url,
            'telegram_url' => (string)$this->telegram_url,
            'facebook_url' => (string)$this->facebook_url,
            'youtube_url' => (string)$this->youtube_url,
            'discord_url' => (string)$this->discord_url,
            'instagram_url' => (string)$this->instagram_url,
        ];
    }
}
