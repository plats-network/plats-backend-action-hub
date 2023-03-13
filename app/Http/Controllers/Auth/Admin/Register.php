<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\RegisRequest;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class Register extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisRequest $request)
    {
        try {
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'role' => CLIENT_ROLE,
                'email_verified_at' => now()
            ]);
        } catch (Exception $exception) {
            return redirect('/cws')->withErrors(['message' => 'Error: Liên hệ admim']);
        }

        return redirect('/cws')->with('success', 'Create account successful');
    }
}
