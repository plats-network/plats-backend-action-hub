<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Repositories\DetailRewardRepository;
use App\Http\Resources\BoxResource;

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
}
