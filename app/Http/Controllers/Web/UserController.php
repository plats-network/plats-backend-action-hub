<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

class UserController extends Controller
{
    public function __construct()
    {
        // code
    }

    public function profile(Request $request)
    {
        try {
            $user = Auth::user();

            if ($user && $user->role != USER_ROLE) {
                Auth::login($user);
            }
        } catch (\Exception $e) {
            notify()->error('Có lỗi xảy ra');
            Log::error('Errors: '. $e->getMessage());

            return redirect()->route('web.home');
        }

        return view('web.user.profile', [
            'user' => $user,
        ]);
    }
}
