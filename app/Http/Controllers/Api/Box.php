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

        $boxs = $this->detailRewardRepository
            ->getRewards($userId, REWARD_BOX)
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function used(Request $request)
    {
        $limit = $request->get('limit') ?? PAGE_SIZE;
        $userId = $request->user()->id;

        $boxUseds = $this->detailRewardRepository
            ->getRewards($userId, REWARD_BOX, true)
            ->paginate($limit);

        if ($boxUseds->isEmpty()) {
            return $this->respondNotFound();
        }

        $datas = BoxResource::collection($boxUseds);
        $pages = [
            'current_page' => (int)$request->get('page'),
            'last_page' => $boxUseds->lastPage(),
            'per_page'  => (int)$limit,
            'total' => $boxUseds->lastPage()
        ];

        return $this->respondWithIndex($datas, $pages);
    }
}
