<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BLCGatewayService
{
    /**
     * @param int $amount
     * @param string $taskId
     * @param string $walletAddress
     *
     * @return \Illuminate\Http\Client\Response
     */
    public function award($amount, $taskId, $walletAddress)
    {
        $actionUrl = $this->getGatewayUrl() . '/reward/award';

        $query = [
            'task_id' => $taskId,
            'amount'  => $amount,
            'address' => $walletAddress
        ];

        return Http::get($actionUrl, $query);
    }

    /**
     * @param $amount
     * @param string $transactionId
     * @param string $walletAddress
     *
     * @return \Illuminate\Http\Client\Response
     */
    public function withdraw($amount, $transactionId, $walletAddress)
    {
        unset($amount);//Default withdraw all balance
        $actionUrl = $this->getGatewayUrl() . '/withdraw/claim';

        $query = [
            'transaction_id' => $transactionId,
            'amount'         => '',
            'address'        => $walletAddress,
        ];

        return Http::get($actionUrl, $query);
    }

    /**
     * @return string
     */
    private function getGatewayUrl()
    {
        return config('blc.connection.host') . ':' . config('blc.connection.port');
    }
}
