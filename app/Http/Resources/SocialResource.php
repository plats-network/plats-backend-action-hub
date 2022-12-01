<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use App\Helpers\{DateHelper, ActionHelper};
use Illuminate\Support\Facades\Http;
use App\Models\{TaskUser, Reward};
use Carbon\Carbon;
use App\Http\Resources\TaskGuideResource;

class SocialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $isDoneTask = true;
        $userId = $request->user()->id;
        $token = $request->user()->token;
        $creator = $this->getUserDetail($token, $this->creator_id);
        $mainImgs[] =  ['url' => $this->cover_url];
        $rewards = Reward::where('end_at', '>=', Carbon::now())->first();
        $galleries = GalleryResource::collection($this->galleries()->get());
        $checkUserTask = TaskUser::select('id')->whereUserId($userId)->whereTaskId($this->id)->count();

        foreach($this->taskSocials()->get() as $item) {
            $taskUser = TaskUser::whereUserId($userId)
                ->whereTaskId($this->id)
                ->whereSocialId($item->id)
                ->first();
            if (!$taskUser || $taskUser->status != USER_COMPLETED_TASK) {
                $isDoneTask = false;
                break;
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_done' => $isDoneTask,
            'description' => $this->description,
            'type' => ActionHelper::getType($this->type),
            'task_start' => $checkUserTask > 0 ? true : false,
            'cover_url' => $this->cover_url,
            'post_by' => $creator ? $creator['name'] : 'Plats Team',
            'socials' => TaskSocialResource::collection($this->taskSocials()->get()),
            'galleries' => count($galleries) > 0 ? $galleries : $mainImgs,
            'rewards' => $rewards,
        ];
    }

    /**
     * Retrieve a user by userId
     *
     * @param $userId
     *
     */
    protected function getUserDetail($token, $userId)
    {
        try {
            $url = config('app.api_user_url') . '/api/profile/' . $userId;
            $response = Http::withToken($token)->get($url);
        } catch (\Exception $e) {
            return null;
        }

        return $response->json('data') ?? null;
    }
}
