<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Services\OpenBoxService;

class OpenBox extends ApiController
{
    /**
     * @var \App\Services\OpenBoxService
     */
    protected $openBoxService;

    public function __construct(OpenBoxService $openBoxService)
    {
        $this->openBoxService  = $openBoxService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $openBox = $this->openBoxService->update($userId);
        
        # Todo: 
        return $this->responseMessage('Done');
    }
}
