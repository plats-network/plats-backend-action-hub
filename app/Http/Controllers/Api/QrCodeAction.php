<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QrCodeRequest;
use App\Http\Middleware\QrCode;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\UserTaskReward;
use App\Models\DetailReward;
use Carbon\Carbon;

class QrCodeAction extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        private UserTaskReward $userTaskReward,
        private DetailReward $detailReward,
    )
    {
       $this->middleware('qrcode');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QrCodeRequest $request)
    {
        try {
            $code_voucher = $request->code_voucher;
            $detailReward = DetailReward::whereNotNull('qr_code')
                ->where('qr_code', $code_voucher)
                ->first();

            if (!$detailReward) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data not found!',
                    'error_code' => 2
                ], 404);
            }

            $userTaskReward = $this->userTaskReward
                ->where('detail_reward_id', $detailReward->id)
                ->first();

            if (!$userTaskReward) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data not found!',
                    'error_code' => 2
                ], 404);
            }

            if ($userTaskReward->is_consumed == true) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Used!',
                    'error_code' => 3
                ], 200);
            }

            $userTaskReward->update([
                'is_consumed' => true,
                'consume_at' => Carbon::now()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error 500!',
                'error_code' => 4
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Success!',
            'error_code' => 0
        ], 200);
    }
}
