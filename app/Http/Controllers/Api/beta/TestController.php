<?php

namespace App\Http\Controllers\Api\beta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
        return $this->responseApiSuccess(['test'=>'success']);
    }
}
