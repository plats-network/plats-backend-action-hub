<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RewardRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Repositories\RewardRepository;
use App\Models\Reward as RewardModel;
use Auth;

class Reward extends Controller
{
    /**
     * @param App\Repositories\RewardRepository $rewardRepository
     */
    public function __construct(
        private RewardRepository $rewardRepository
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rewards = $this->rewardRepository->paginate(PAGE_SIZE);

        return view(
            'admin.reward.index',
            ['rewards' => $rewards]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Remove flash session fields before from visited
        if (!empty(request()->old())) {
            $this->flashReset();
        }

        return view('admin.reward.create');
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
        $assign = [];
        $assign['reward'] = RewardModel::findOrFail($id);

        // Save detail to session
        if (empty(request()->old()) || old('id') != $id) {
            $this->flashSession($assign['reward']);
        }

        return view('admin.reward.edit', $assign);
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
        //
    }
}
