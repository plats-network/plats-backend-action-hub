<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Repositories\DetailRewardRepository;
use Carbon\Carbon;
use App\Http\Resources\{BoxResource, UnboxResource};
use App\Models\{DetailReward, UserTaskReward};

class Box extends ApiController
{
    public function __construct(
        private DetailRewardRepository $detailRewardRepository,
        private UserTaskReward $userTaskReward,
        private DetailReward $detailReward
    ) {
        // CODE: 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        try {
            $userId = $request->user()->id;
            $data = $this->detailRewardRepository->getReward($userId, $id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        return $this->respondWithResource(new BoxResource($data));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $bonus = null;

        try {
            $userId = $request->user()->id;
            $data = $this->detailRewardRepository->getReward($userId, $id);

            if ($data->user_task_reward) {
                if (optional($data->user_task_reward)->is_open == 1) {
                    return $this->responseMessage('Open boxed!');
                } else {
                    $this->userTaskReward
                        ->whereUserId($userId)
                        ->whereDetailRewardId($id)
                        ->update([
                            'is_open' => true,
                            'amount' => $data->amount ?? 0,
                            'is_tray' => true,
                            'type' => $data->type
                        ]);
                    $this->detailReward
                        ->whereId($id)
                        ->update([
                            'updated_at' => Carbon::now()
                        ]);
                }
            }

            $bonus = $this->userTaskReward
                ->whereUserId($userId)
                ->whereDetailRewardId($id)
                ->first();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        return $this->respondWithResource(new UnboxResource($bonus));
    }
}
