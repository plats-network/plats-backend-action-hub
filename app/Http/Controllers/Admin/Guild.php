<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class Guild extends Controller
{
    public function __construct(
    ) {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.guild.index');
    }
}
