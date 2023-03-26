<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Auth\Authenticates;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    use Authenticates;

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function showFormLogin()
    {
        if (Auth::guard('web')->user()) {
            return redirect('/');
        }

        return view('web.auth.login');
    }

    /**
     * Redirect URl after the user was authenticated.
     *
     * @return string
     */
    public function redirectToWeb()
    {
        return route(DASHBOARD_WEB_ROUTER);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
    }
}
