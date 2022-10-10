<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Repositories\DetailRewardRepository;
use App\Http\Resources\VoucherResource;
use Carbon\Carbon;

class VoucherHistories extends ApiController
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
        // dd($userId);

        $histories = $this->detailRewardRepository
            ->getRewards($userId, REWARD_VOUCHER, true)
            ->paginate($limit);

        if ($histories->isEmpty()) {
            return $this->respondNotFound();
        }

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function expired(Request $request)
    {
        $limit = $request->get('limit') ?? PAGE_SIZE;
        $userId = $request->user()->id;

        $histories = $this->detailRewardRepository
            ->getRewards($userId, REWARD_VOUCHER, false, true)
            ->paginate($limit);

        if ($histories->isEmpty()) {
            return $this->respondNotFound();
        }

        $datas = VoucherResource::collection($histories);
        $pages = [
            'current_page' => (int)$request->get('page'),
            'last_page' => $histories->lastPage(),
            'per_page'  => (int)$limit,
            'total' => $histories->lastPage()
        ];

        return $this->respondWithIndex($datas, $pages);
    }
}
