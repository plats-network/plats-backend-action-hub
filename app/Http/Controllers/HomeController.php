<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DetailRewardRepository;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct(
        private DetailRewardRepository $detailRewardRepository
    ) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $detail = $this->detailRewardRepository->getDetail($id);
        } catch(\Exception $e) {
            abort(404);
        }

        return view('home.show', [
            'detail' => $detail,
            'from' => is_null($detail->start_at) ? null : Carbon::parse($detail->start_at)->format('H:i, d/m'),
            'to' => is_null($detail->end_at) ? null : Carbon::parse($detail->end_at)->format('H:i, d/m/Y')
        ]);
    }
}
