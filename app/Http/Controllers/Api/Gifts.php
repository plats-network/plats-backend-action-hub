<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Repositories\DetailRewardRepository;
use App\Http\Resources\VoucherResource;
use Carbon\Carbon;

class Gifts extends ApiController
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
        $type = $request->get('type');
        $status = $request->get('status');
        $histories = null;

        if ($type == 'token') {
            $histories = $this->detailRewardRepository->getNftTokens($userId, 0);
        } elseif ($type == 'nft') {
            $histories = $this->detailRewardRepository->getNftTokens($userId, REWARD_NFT);
        } elseif ($type == 'gift') {
            if ($status == 'used') {
                $histories = $this->detailRewardRepository->getGiftUses($userId);
            } elseif ($status == 'expired') {
                $histories = $this->detailRewardRepository->getGiftExp($userId);
            } else {
                $histories = $this->detailRewardRepository->getGifts($userId);
            }
        }

        if (is_null($histories)) { return $this->respondNotFound('Data not found!'); }
        $histories = $histories->paginate($limit);
        if ($histories->isEmpty()) { return $this->respondNotFound('Data not found!'); }

        $datas = VoucherResource::collection($histories);
        $pages = [
            'current_page' => (int)$request->get('page'),
            'last_page' => $histories->lastPage(),
            'per_page'  => (int)$limit,
            'total' => $histories->lastPage()
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
                ->getReward($userId, $id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        return $this->respondWithResource(new VoucherResource($data));
    }
}
