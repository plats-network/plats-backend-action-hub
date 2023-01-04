<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Http;

class TaskResource extends JsonResource
{
    public function toArray($request)
    {
        $token = $request->user()->token;
        $creator = $this->getUserDetail($token, $this->creator_id);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image'           => $this->banner_url,
            'type'              => $this->type,
            'status'              => $this->status,
            'post_by' => $creator ? $creator['name'] : 'Plats Team',
            'locations'              => $this->taskLocations,
            'socials'              => $this->taskSocials,
            'galleries'              => $this->taskGalleries,
        ];
    }
    protected function getUserDetail($token, $userId)
    {
        try {
            $url = config('app.api_user_url') . '/api/cws/' . $userId;
            $response = Http::withToken($token)->get($url);
        } catch (\Exception $e) {
            return null;
        }

        return $response->json('data') ?? null;
    }
}
