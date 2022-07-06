<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\NotificationResource;
use App\Http\Requests\CreateNotificationRequest;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class Notification extends ApiController
{
    /**
     * @var \App\Services\NotificationService
     */
    protected $notificationService;

    /**
     * @param NotificationService $taskService
     */
    public function __construct(NotificationService $taskService)
    {
        $this->notificationService = $taskService;
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResource
     */
    public function detail(Request $request, $id)
    {
        $notifications = $this->notificationService->find($id);

        return new NotificationResource($notifications);
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return NotificationResource::collection($this->notificationService->home($request->user()->id));
    }

    /**
        * @param CreateNotificationRequest $request
         * @return JsonResource
     */
    public function create(CreateNotificationRequest $request)
    {
        try {
            $title = $request->input('title');
            $content = $request->input('content');
            $data = $request->input('data');
            $userId = $request->user()->id;

            return new NotificationResource($this->notificationService->create([
                'title' => $title,
                'content' => $content,
                'data' => $data,
                'user_id' => $userId,
            ]));
        }
        catch (\Exception $e) {
            return new NotificationResource($e->getMessage());
        }
    }

}
