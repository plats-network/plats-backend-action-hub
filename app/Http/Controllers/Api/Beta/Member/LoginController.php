<?php

namespace App\Http\Controllers\Api\Beta\Member;

use App\Http\Controllers\Controller;
use App\Mail\VerifyCode;
use App\Models\Beta\User\Users;
use App\Models\Event\TaskEventDetail;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function __construct(
        private TaskEventDetail $taskEventDetail
    )
    {
    }

    public function loginSocial()
    {

        return view('beta.test');
    }

    public function loginRedirectGithub()
    {

        return Socialite::driver('github')->redirect();
    }

    public function loginCallbackGithub()
    {

        $user = Socialite::driver('github')->user();

        return response()->json($user);
    }

    public function loginRedirectGoogle()
    {

        return Socialite::driver('google')->redirect();
    }

    public function loginCallbackGoogle()
    {

        $user = Socialite::driver('google')->user();

        return response()->json($user);
    }

    public function loginRedirectApple()
    {

        return 1113232;
    }

    public function loginCallbackApple()
    {

        return 111;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->responseApiError([], $validator->errors()->first());
        }
        try {
            $data = $request->all();
            $user = new Users();
            $user->fullname = $data['fullname'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->address = $data['address'] ?? '';
            $user->birthday = $data['birthday'] ?? '';
            $user->verify_code = rand(100000, 999999);
            $user->save();
            //send mail
            if ($user) {
                $code = $user->verify_code;
                Mail::to($user)->send(new VerifyCode($user, $code));
            }
            return $this->responseApiSuccess($user, 'Register success');
        } catch (\Exception $e) {
            return $this->responseApiError([], $e->getMessage());
        }

    }

}
