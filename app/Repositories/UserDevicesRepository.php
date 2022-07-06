<?php

namespace App\Repositories;

use App\Http\Resources\NotificationResource;
use App\Models\UserDevices;
use App\Repositories\Concerns\BaseRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserDevicesRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return UserDevices::class;
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
     * @param $userId
     * @return mixed
     */
    public function latestDevices($userId)
    {
        return $this->model->where('user_id', $userId)->latest()->get();
    }
}
