<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Http\Requests\Admin\RegisRequest;
use App\Http\Requests\Web\SignUpRequest;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class SignUp extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSignup()
    {
        return view('web.auth.signup');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SignUpRequest $request)
    {
        try {
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'role' => USER_ROLE,
                'email_verified_at' => now()
            ]);
        } catch (Exception $exception) {
            return redirect('/')->withErrors(['message' => 'Error: Liên hệ admim']);
        }

        return redirect('client/login')->with(['message' => 'Login success']);
    }
}
