<?php

namespace App\Repositories;

use App\Models\Company;
use App\Repositories\Concerns\BaseRepository;

class CompanyRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Company::class;
    }

    /**
     * @param $taskId
     * @param $locaId
     *
     * @return mixed
     */
    // public function taskHasLocation($taskId, $locaId)
    // {
    //     return $this->model
    //         ->hasLocation($locaId)
    //         ->findOrFail($taskId);
    // }
}
