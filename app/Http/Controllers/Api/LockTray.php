<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Repositories\DetailRewardRepository;
use App\Http\Resources\QrCodeResource;
use App\Http\Resources\LockTrayResource;
use Carbon\Carbon;
use App\Models\UserTaskReward;
use App\Models\DetailReward;

class LockTray extends ApiController
{
    public function __construct(
        private DetailRewardRepository $detailRewardRepository,
        private UserTaskReward $userTaskReward,
        private DetailReward $detailReward
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit') ?? PAGE_SIZE;
        $userId = $request->user()->id;

        $lockTray = $this->detailRewardRepository
            ->getLockTray($userId)
            ->paginate($limit);

        if ($lockTray->isEmpty()) {
            return $this->respondNotFound();
        }

        $datas = LockTrayResource::collection($lockTray);
        $pages = [
            'current_page' => (int)$request->get('page'),
            'last_page' => $lockTray->lastPage(),
            'per_page'  => (int)$limit,
            'total' => $lockTray->lastPage()
        ];

        return $this->respondWithIndex($datas, $pages);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $userId = $request->user()->id;
            $data = $this->detailRewardRepository
                ->getReward($userId, $id, null);

            if ($data) {
                if ($data->end_at && Carbon::now() < $data->end_at) {
                    return $this->respondError('Date not yet!', 422);
                } elseif (optional($data->user_task_reward)->is_tray == 1) {
                    return $this->responseMessage('Đã chuyển sang main tray!...');
                } else {
                    $this->userTaskReward
                        ->whereUserId($userId)
                        ->whereDetailRewardId($id)
                        ->update([
                            'is_tray' => true
                        ]);
                    $this->detailReward
                        ->whereId($id)
                        ->update(['updated_at' => Carbon::now()]);
                }
            }
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        return $this->responseMessage('Send to Main Tray done!...');
    }
}
