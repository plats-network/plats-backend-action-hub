<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Repositories\DetailRewardRepository;
use App\Http\Resources\QrCodeResource;

class QrCode extends ApiController
{
    public function __construct(
        private DetailRewardRepository $detailRewardRepository
    ) {}
    /**

     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, Request $request)
    {
        try {
            $userId = $request->user()->id;
            $data = $this->detailRewardRepository
                ->getReward($userId, $id, REWARD_VOUCHER);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('QrCode not found!');
        }

        return $this->respondWithResource(new QrCodeResource($data));
    }
}
