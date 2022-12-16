<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\RewardRequest;
use App\Http\Resources\Admin\RewardResource;
use App\Models\Reward as RewardModel;
use App\Repositories\RewardRepository;
use App\Services\Admin\RewardService;
use Illuminate\Http\Request;

class Reward extends ApiController
{
    /**
     * @param App\Repositories\RewardRepository $rewardRepository
     */
    public function __construct(
        private RewardService $rewardService
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword['name'] = $request->input('name');
        $rewards = $this->rewardService->search($keyword + ['limit' => $request->get('limit') ?? PAGE_SIZE]);
        return $this->respondWithResource(new RewardResource($rewards));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RewardRequest $request)
    {
        //
        $reward = $this->rewardService->store($request);
        return $this->respondWithResource(new RewardResource($reward));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reward = RewardModel::findOrFail($id);
        return $this->respondWithResource(new RewardResource($reward));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RewardRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->rewardService->delete($id);
        return $this->responseMessage('delete success !');
    }
}
