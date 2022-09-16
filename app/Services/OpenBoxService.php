<?php

namespace App\Services;

use App\Repositories\UserBoxRepository;
use App\Services\Concerns\BaseService;

class OpenBoxService extends BaseService
{
    protected $userRepository;

    /**
     * @param \App\Repositories\UserBoxRepository $userRepository
     */
    public function __construct(UserBoxRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function update($userId)
    {
        $userBox = $this->userRepository->un_box($userId);

        if ($userBox) {
            $userBox->update(['is_unbox' => true]);

            return $userBox;
        }

        return $this->userRepository->open_box($userId);
    }
}
