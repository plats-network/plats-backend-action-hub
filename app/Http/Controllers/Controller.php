<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\SessionFormRequestTrait;
use App\Services\Traits\ApiResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, SessionFormRequestTrait, ApiResponseTrait;

    public function responseApiSuccess($data, $message = 'success'): \Illuminate\Http\JsonResponse
    {
        $responseData = [
            'error_code' => 0,
            'message' => $message,
            'data' => $data,
        ];
        return response()
            ->json($responseData, 200);
    }

    /**
     * @param $data
     * @param string $message
     *
     * @return JsonResponse
     */
    public function responseApiError($data, string $message = 'Có lỗi xảy ra!', $code = 400): \Illuminate\Http\JsonResponse
    {

        $responseMessage = [];
        
        if(is_array($message)){
            foreach($message as $m){
                if(is_array($m)){
                    $m = array_shift($m);
                }
                $responseMessage[] = $m;
            }
        }
        $responseMessage = empty($responseMessage) ? $message : implode(" ", $responseMessage);
        $responseData = [
            'error_code' => 1,
            'message' => $responseMessage,
            'data' => $data,
        ];
        return response()
            ->json($responseData, $code);
    }
}
