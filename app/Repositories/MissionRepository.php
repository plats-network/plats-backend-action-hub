<?php

namespace App\Repositories;

use App\Models\Mission;
use App\Repositories\Concerns\BaseRepository;

class MissionRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Mission::class;
    }
}
