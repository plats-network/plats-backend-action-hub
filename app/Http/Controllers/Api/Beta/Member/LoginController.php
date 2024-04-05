<?php

namespace App\Http\Controllers\Api\Beta\Member;

use App\Http\Controllers\Controller;
use App\Models\Event\TaskEventDetail;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function __construct(
        private TaskEventDetail $taskEventDetail
    )
    {}
    
    public function loginSocial(){

        return view('beta.test');
    }

    public function loginRedirectGithub(){

        return Socialite::driver('github')->redirect();
    }

    public function loginCallbackGithub(){

        $user = Socialite::driver('github')->user();

        return response()->json($user);
    }

    public function loginRedirectGoogle(){

        return Socialite::driver('google')->redirect();
    }

    public function loginCallbackGoogle(){

        $user = Socialite::driver('google')->user();
        
        return response()->json($user);
    }   

    public function loginRedirectTwitter(){
        
        return Socialite::driver('twitter')->redirect();
    }

    public function loginCallbackTwitter(){
        
        $user = Socialite::driver('twitter')->user();

        return response()->json($user);
    }

    public function loginRedirectFacebook(){
        
        return Socialite::driver('facebook')->redirect();
    }

    public function loginCallbackFacebook(){
        
        $user = Socialite::driver('facebook')->user();
        
        return response()->json($user);
    }
}
