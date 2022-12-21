<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\WithdrawRequest;
use App\Services\WithdrawService;
use Illuminate\Http\Request;

class Wallet extends ApiController
{
    /**
     * @var \App\Services\WithdrawService
     */
    protected $withdrawService;

    /**
     * @param \App\Services\WithdrawService $withdrawService
     */
    public function __construct(WithdrawService $withdrawService)
    {
        $this->withdrawService = $withdrawService;
    }

    /**
     * @param WithdrawRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function withdraw(WithdrawRequest $request)
    {
        $this->withdrawService->claim(
            $request->user()->id,
            $request->input('wallet_address'),
            $request->input('amount', 0)
        );

        return $this->responseMessage('Done');
    }
}
