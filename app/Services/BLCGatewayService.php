<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BLCGatewayService
{
    /**
     * @param $amount
     * @param $taskId
     *
     * @return \Illuminate\Http\Client\Response
     */
    public function award($amount, $taskId)
    {
        $actionUrl = $this->getGatewayUrl() . '/reward/award';

        $query = [
            'task_id' => $taskId,
            'amount'  => $amount,
            //'address' => ''
        ];

        return Http::get($actionUrl, $query);
    }

    /**
     * @param $amount
     * @param $transactionId
     *
     * @return \Illuminate\Http\Client\Response
     */
    public function withdraw($amount, $transactionId)
    {
        $actionUrl = $this->getGatewayUrl() . '/withdraw/claim';

        $query = [
            'transaction_id' => $transactionId,
            'amount'         => $amount,
            //'address' => ''
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
