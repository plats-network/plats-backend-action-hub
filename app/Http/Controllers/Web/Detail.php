<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class Detail extends Controller
{
    public function __construct()
    {
        $this->middleware('client_web');
    }

    public function index()
    {
            dd(1);
    }

}
