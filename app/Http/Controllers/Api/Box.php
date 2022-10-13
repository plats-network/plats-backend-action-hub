<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Repositories\DetailRewardRepository;
use App\Http\Resources\BoxResource;
use App\Http\Resources\UnboxResource;



class Box extends ApiController
{
    public function __construct(
        private DetailRewardRepository $detailRewardRepository
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
        $type = $request->get('type') == 'unbox' ? true : false;

        $boxs = $this->detailRewardRepository
            ->getRewards($userId, REWARD_BOX, $type)
            ->paginate($limit);;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $bonus = null;
        try {
            $userId = $request->user()->id;
            $data = $this->detailRewardRepository->getReward($userId, $id, REWARD_BOX);

            if ($data->user_task_reward) {
                if (optional($data->user_task_reward)->amount > 0) {
                    return $this->responseMessage('Open boxed!');
                }

                $data->user_task_reward->update([
                    'amount' => $data->amount ?? 120,
                    'type' => REWARD_BOX
                ]);
            }

            $bonus = $data->user_task_reward;
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        return $this->respondWithResource(new UnboxResource($bonus));
    }
}
