<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;

class Dashboard extends Controller
{
    public function __construct()
    {
        $this->middleware('client_admin');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.dashboard.index');
    }
}
