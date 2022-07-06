<?php

namespace App\Repositories;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Repositories\Concerns\BaseRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NotificationRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Notification::class;
    }

    /**
     * @param $userId
     *
     * @return AnonymousResourceCollection
     */
    public function home($userId): AnonymousResourceCollection
    {
        return $this->model->where('user_id', $userId)->get();
    }

    /**
     * @param array $data
     *
     * @return NotificationResource
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @return mixed
     */
    public function latestNotifications($user_id, $limit = PAGE_SIZE)
    {
        //get latest limit
        return $this->model->where('user_id', $user_id)->latest()->limit($limit)->get();
    }

}
