<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Repositories\DetailRewardRepository;
use App\Http\Resources\VoucherResource;
use Carbon\Carbon;

class Vouchers extends ApiController
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

        $vouchers = $this->detailRewardRepository
            ->getRewards($userId, REWARD_VOUCHER)
            ->paginate($limit);

        if ($vouchers->isEmpty()) {
            return $this->respondNotFound('Data not found!');
        }

        $datas = VoucherResource::collection($vouchers);
        $pages = [
            'current_page' => (int)$request->get('page'),
            'last_page' => $vouchers->lastPage(),
            'per_page'  => (int)$limit,
            'total' => $vouchers->lastPage()
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
                ->getReward($userId, $id, REWARD_VOUCHER);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        return $this->respondWithResource(new VoucherResource($data));
    }
}
