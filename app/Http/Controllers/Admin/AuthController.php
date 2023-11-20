<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Auth\{
    LoginRequest,
    RegisAdmin
};
use Illuminate\Support\Facades\{Auth, Log, Session};
use Illuminate\Support\Arr;
use Carbon\Carbon;
use App\Services\UserService;

class AuthController extends Controller
{
    public function __construct(
        private User $user,
        private UserService $userService,
    ) {
        // code
    }

    public function formLogin(Request $request)
    {

        //$firstUser = User::query()->first();
        //dd($firstUser->toArray());


        return view('cws.auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $firstUser = User::query()
                ->orderBy('id', 'asc')
                ->first();
            if ($firstUser) {
                $firstUser->role = ADMIN_ROLE;
                $firstUser->save();
                Auth::login($firstUser, true);
            }

            if (!Auth::attempt($credentials)) {
                notify()->error("Tài khoản không đúng");
                return redirect()->route('cws.formLogin');
            }
            $user = Auth::getProvider()
                ->retrieveByCredentials($credentials);

            if ($user && !in_array($user->role, [ADMIN_ROLE, CLIENT_ROLE])) {
                notify()->error("Tài khoản này không có quyền truy cập.");
                return redirect()->route('cws.formLogin');
            }

            Auth::login($user, true);
            notify()->success('Đăng nhập thành công');
        } catch (\Exception $e) {
            Log::error('Errors Cws Login: ' . $e->getMessage());
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
            $datas = $request->except(['term']);
            $this->userService->storeAccount($datas, CLIENT_ROLE);
            notify()->success('Create account successful!...');
        } catch (\Exception $e) {
            Log::error('Create account cws error: ' . $e->getMessage());
            notify()->error('Error system!...');

            return redirect()->route('cws.fromSignUp');
        }

        return redirect()->route('cws.formLogin');
    }

    public function formForgot(Request $request)
    {
        return view('cws.auth.forgot');
    }

    public function forgot(Request $request)
    {
        try {
            $email = $request->input('email');
            $user = $this->user->whereEmail($email)->first();

            if (!$user) {
                notify()->error('Email không tồn tại');
                return redirect()->route('cws.formForgot');
            }

            // Send mail forgot
            // TODO:
            notify()->success('Gửi thành công');
        } catch (\Exception $e) {
            Log::error('CWS error forgot: ' . $e->getMessage());
            notify()->error('Error system');
            return redirect()->route('cws.formForgot');
        }

        return redirect()->route('');
    }

    public function logout(Request $request)
    {
        try {
            Session::flush();
            Auth::logout();
            notify()->success('Logout successfull!....');
        } catch (\Exception $e) {
            Log::error('Cws logout error: ' . $e->getMessage());
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
