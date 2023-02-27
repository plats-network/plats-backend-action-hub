<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class Dashboard extends Controller
{


    public function index()
    {
        return view('web.home');
    }
    public function detail()
    {
        return view('web.detail');
    }
}
