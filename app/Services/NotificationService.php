<?php

namespace App\Services;

use App\Http\Resources\NotificationResource;
use App\Repositories\NotificationRepository;
use App\Services\Concerns\BaseService;
use Illuminate\Pagination\Paginator;

class NotificationService extends BaseService
{
    /**
     * @param NotificationRepository $repository
     */
    protected $repository;

    /**
     * @param NotificationRepository $repository
     */
    public function __construct(NotificationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $userId
     * @return Paginator
     */
    public function home($userId, $page = 1, $limit = PAGE_SIZE)
    {
        $notifications = $this->repository->latestNotifications($userId);

        return new Paginator($notifications, $limit, $page);
    }

    /**
     * @param array $data
     * @return NotificationResource
     */
    public function create(array $data)
    {
        return $this->repository->create($data);
    }
}
