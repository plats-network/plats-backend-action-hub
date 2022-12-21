<?php

namespace App\Repositories;

use App\Models\BoxUser;
use App\Repositories\Concerns\BaseRepository;

class UserBoxRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BoxUser::class;
    }

    /**
     * @param $userId
     *
     * @return null | BoxUser
     */
    public function open_box($userId)
    {
        return $this->model
        ->whereUserId($userId)
        ->whereIsUnbox(true)
        ->first();
    }

    /**
     * @param $userId
     *
     * @return null | BoxUser
     */
    public function un_box($userId)
    {
        return $this->model
        ->whereUserId($userId)
        ->whereIsUnbox(false)
        ->first();
    }
}
