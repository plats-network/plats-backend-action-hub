<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class Analytics extends Controller
{
    public function index()
    {
        return view('admin.analytics.index');
    }
}
