<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class Task extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.task.index');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.task.create');
    }
}
