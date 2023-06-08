<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {

    }

    public function profile(Request $request)
    {
        try {

        } catch (\Exception $e) {
            
        }

        return view('web.user.profile', [
            'user' => Auth::user(),
        ]);
    }
}
