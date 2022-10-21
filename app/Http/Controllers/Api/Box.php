<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Repositories\DetailRewardRepository;
use App\Http\Resources\BoxResource;
use App\Http\Resources\UnboxResource;
use Carbon\Carbon;
use App\Models\UserTaskReward;
use App\Models\DetailReward;

class Box extends ApiController
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
        $openFlag = $request->get('type') == 'unbox' ? true : false;

        $boxs = $this->detailRewardRepository
            ->getBoxs($userId, $openFlag)
            ->paginate($limit);

        if ($boxs->isEmpty()) {
            return $this->respondNotFound();
        }

        $datas = BoxResource::collection($boxs);
        $pages = [
            'current_page' => (int)$request->get('page'),
            'last_page' => $boxs->lastPage(),
            'per_page'  => (int)$limit,
            'total' => $boxs->lastPage()
        ];

        return $this->respondWithIndex($datas, $pages);
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
            $data = $this->detailRewardRepository
                ->getReward($userId, $id, null);
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
            $data = $this->detailRewardRepository
                ->getReward($userId, $id, null);

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
                            'type' => $data->type
                        ]);
                    $this->detailReward
                        ->whereId($id)
                        ->update(['updated_at' => Carbon::now()]);
                }
            }

            $bonus = $data->user_task_reward;
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        return $this->respondWithResource(new UnboxResource($bonus));
    }
}
