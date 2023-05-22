<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Auth\{
    LoginRequest,
    RegisAdmin
};
use Illuminate\Support\Facades\Auth;
use Log;
use Session;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function __construct(
        private User $user,
    ) {
        // code
    }

    public function formLogin(Request $request)
    {
        return view('cws.auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                notify()->error("Tài khoản không đúng");
                return redirect()->route('cws.formLogin');
            }
            $user = Auth::getProvider()
                ->retrieveByCredentials($credentials);

            Auth::login($user);
            notify()->success('Đăng nhập thành công');
        } catch (\Exception $e) {
            Log::err('Errors Cws Login: ' . $e->getMessage());
            return redirect()->route('cws.formLogin');
        }

        return $this->authenticated($request, $user);
    }

    public function fromSignUp(Request $request)
    {
        return view('cws.auth.register');
    }

    public function register(RegisAdmin $request)
    {
        try {
            $this->user->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'email_verified_at' => Carbon::now(),
                'role' => CLIENT_ROLE
            ]);

            notify()->success('Create account successful!...');
        } catch (\Exception $e) {
            Log::err('Create account cws error: ' . $e->getMessage());
            notify()->error('Error system!...');

            return redirect()->route('cws.fromSignUp');
        }

        return redirect()->route('cws.formLogin');
    }

    public function logout(Request $request)
    {
        try {
            Session::flush();
            Auth::logout();
            notify()->success('Logout successfull!....');
        } catch (\Exception $e) {
            Log::err('Cws logout error: ' . $e->getMessage());
            notify()->error('Error system!...');
            return redirect()->route('cws.formLogin');
        }

        return redirect()->route('cws.formLogin');
    }

    private function authenticated($request, $user)
    {
        return redirect()->intended();
    }
}
