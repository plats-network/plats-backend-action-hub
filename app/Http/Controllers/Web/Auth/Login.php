<?php

namespace App\Http\Controllers\Web\Auth;

// use App\Http\Controllers\Auth\Authenticates;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\Rule;
use App\Models\Event\{
    EventUserTicket,
    TaskEvent,
    TaskEventDetail,
    UserJoinEvent
};

class Login extends Controller
{
    // use Authenticates;

    public function __construct(
        private User $user,
        private EventUserTicket $eventTicket,
        private TaskEventDetail $eventDetail,
        private UserJoinEvent $userEvent,
        private TaskEvent $taskEvent,
    ) {
        // Code
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                notify()->error("Tài khoản không đúng");
                return redirect()->route('web.formLogin');
            }
            $user = Auth::getProvider()
                ->retrieveByCredentials($credentials);

            if ($user && $user->status != USER_ACTIVE) {
                notify()->success('Tài khoản chưa active');
                return redirect()->route('web.formLogin');
            }

            Auth::login($user, true);
            notify()->success('Đăng nhập thành công');
        } catch (\Exception $e) {
            Log::error('Errors Cws Login: ' . $e->getMessage());
            return redirect()->route('cws.formLogin');
        }

        return $this->authenticated($request, $user);
    }

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
     * Handle redirect to Provider
     *
     * @param Request $request The request object.
     */
    public function redirectToProvider(Request $request)
    {
        $request->validate([
            'providerName' => ['required', Rule::in(['facebook', 'google'])],
        ]);;
        return Socialite::driver($request->providerName)->redirect();
    }

    /**
     * Handle Provider callback
     *
     * @param Request $request The request object.
     */
    public function handleProviderCallback(Request $request)
    {
        $providerName = $request->providerName;
        $user = Socialite::driver($providerName)->user();

        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            Auth::login($existingUser);
        } else {
            $newUser = new User();
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->email_verified_at = now();
            if($providerName === 'facebook') {
                $newUser->facebook = $user->id;
            } else if($providerName === 'google') {
                $newUser->google = $user->id;
            }
            $newUser->save();

            Auth::login($newUser);
        }

        return redirect()->to('/');
    }

    public function formLoginGuest(Request $request)
    {
        return view('web.auth.login_guest');
    }

    public function loginGuest(Request $request)
    {
        try {
            $code = session()->get('code');
            $account = $request->input('account');

            if (filter_var($account, FILTER_VALIDATE_EMAIL)) {
                $phone = "0";
                $account = $account;
            } else {
                $phone = $account;
                $account = $account . '@gmail.com';

                if (!$this->isPhone($phone)) {
                    notify()->error('Email hoặc số điện thoại không đúng');
                    return redirect()->route('web.formLoginGuest');
                }
            }

            $user = $this->user->whereEmail($account)->first();
            if ($user && in_array($user->role, [ADMIN_ROLE, CLIENT_ROLE])) {
                notify()->error('Account fail!');

                return redirect()->route('web.formLoginGuest');
            }

            if ($user && $code) {
                Auth::login($user, true);
                notify()->success('Hoàn thành task');
            } elseif ($user && !$code) {
                Auth::login($user, true);
                notify()->success('Login successfull');

                return $this->authenticated($request, $user);
            } else {
                $userName = $request->input('name');

                $eventDetail = $this->eventDetail->whereCode($code)->first();
                $taskEvent = $this->taskEvent
                    ->whereId(optional($eventDetail)->task_event_id)
                    ->first();

                if (!$taskEvent || !$eventDetail) {
                    notify()->error('Vui lòng quest lại QR code');
                    return redirect()->route('web.formLoginGuest');
                }

                $userParams = [
                    'email' => $account,
                    'phone' => (string) $phone,
                    'name' => $userName,
                    'password' => '123456a@',
                    'confirmation_code' => null,
                    'role' => GUEST_ROLE,
                    'email_verified_at' => now()
                ];
                $user = $this->user->create($userParams);

                $tickerParams = [
                    'user_id' => $user->id,
                    'task_id' => optional($taskEvent)->task_id,
                    'name' => $userName,
                    'email' => $account,
                    'phone' => (string) $phone,
                    'is_checkin' => true,
                    'type' => 1,
                ];
                $userEventParams = [
                    'user_id' => $user->id,
                    'task_event_detail_id' => $eventDetail->id,
                    'task_id' => optional($taskEvent)->task_id,
                    'task_event_id' => optional($taskEvent)->id
                ];
                $this->eventTicket->create($tickerParams);
                $this->userEvent->create($userEventParams);
                Auth::login($user, true);

                notify()->success('Hoàn thành task');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            notify()->error('Có lỗi sảy ra');
            return redirect()->route('web.formLoginGuest');
        }

        return redirect()->route('web.home');
    }

    public function logout(Request $request)
    {
        try {
            $user = Auth::user();
            Auth::logout($user);
            notify()->success('Logout successfull');
        } catch (\Exception $e) {
            notify()->error('Có lỗi xảy ra: ' . $e->getMessage());
            return redirect()->route('web.home');
        }

        return redirect()->route('web.home');
    }

    private function isPhone($phone)
    {
        if (!preg_match('/^[0-9]{10}+$/', $phone)) {
            return false;
        }

        return true;
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

    private function authenticated($request, $user)
    {
        return redirect()->intended();
    }
}
