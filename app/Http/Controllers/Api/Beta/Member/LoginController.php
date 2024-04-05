<?php

namespace App\Http\Controllers\Api\Beta\Member;

use App\Http\Controllers\Controller;
use App\Mail\VerifyCode;
use App\Models\Beta\User\Users;
use App\Models\Url;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    public function __construct(
    )
    {
    }

    public function loginSocial()
    {

        return view('beta.test');
    }

    public function loginRedirectGithub()
    {

        try {

            return Socialite::driver('github')->redirect();
        
        } catch (\Throwable $th) {
            return $this->responseApiError([], 'Cant`t login github');
        }
    }

    public function loginCallbackGithub()
    {

        try{

            $githubUser = Socialite::driver('github')->user();

        }catch(Exception $e){

            return $this->responseApiError([], 'Cant`t login github');
        }
       
        // Tìm kiếm người dùng dựa trên email hoặc tạo mới
        $user = Users::firstOrCreate(
            [
                'email' => $githubUser->email ?? rand(11199,9999).'_github@github.com',
                'social'=>'github'
            ],
            [
                'active' => 1,
                'fullname' => $githubUser->nickname,
                'password' => Hash::make($githubUser->email ?? rand(11199,9999).'_github@github.com')
            ]
        );
        
        // Tạo JWT
        $token = Crypt::encryptString(json_encode($user));

        if(empty($token)){

            return $this->responseApiError([], 'Cant`t create token github');
        }

        $data = [
            'id'=>$user->id,
            'fullname'=>$user->fullname,
            'email'=>$user->email
        ];

        //trạng thái thành công
        return $this->respondWithToken($token,$data);
    }

    public function loginRedirectGoogle()
    {
        
        try {

            return Socialite::driver('google')->redirect();
        } catch (\Throwable $th) {
            return $this->responseApiError([], 'Cant`t login google');
        }
      
    }

    public function loginCallbackGoogle()
    {

        try {
            $googleUser = Socialite::driver('google')->user();

        } catch (\Throwable $th) {

            return $this->responseApiError([], 'Cant`t login twitter');
        }        
        // Tìm kiếm người dùng dựa trên email hoặc tạo mới
        $user = Users::firstOrCreate(
            [
                'email' => $googleUser->email ?? rand(11199,9999).'_google@google.com',
                'social'=>'google'
            ],
            [
                'active' => 1,
                'fullname' => $googleUser->name,
                'password' => Hash::make($googleUser->email ?? rand(11199,9999).'_google@google.com')
            ]
        );

        // Tạo JWT
        $token = Crypt::encryptString(json_encode($user));

        if(empty($token)){

            return $this->responseApiError([], 'Cant`t create token google');
        }

        $data = [
            'id'=>$user->id,
            'fullname'=>$user->fullname,
            'email'=>$user->email
        ];

        //trạng thái thành công
        return $this->respondWithToken($token,$data);

    }
    public function loginRedirectTwitter(){

        try {

            return Socialite::driver('twitter')->redirect();
        } catch (\Throwable $th) {
            return $this->responseApiError([], 'Cant`t login twitter');
        }
    }

    public function loginCallbackTwitter(){
        
        try {
            $twitterUser = Socialite::driver('twitter')->user();

        } catch (\Throwable $th) {
            
            return $this->responseApiError([], 'Cant`t login twitter');
        }        

        // Tìm kiếm người dùng dựa trên email hoặc tạo mới
        $user = Users::firstOrCreate(
            [
                'email' => $twitterUser->email ?? rand(11199,9999).'twitter@twitter.com',
                'social'=>'twitter'
            ],
            [
                'active' => 1,
                'fullname' => $twitterUser->name,
                'password' => Hash::make($twitterUser->email ?? rand(11199,9999).'_twitter@twitter.com')
            ]
        );

        // Tạo JWT
        $token = Crypt::encryptString(json_encode($user));

        if(empty($token)){

            return $this->responseApiError([], 'Cant`t create token twitter');
        }

        $data = [
            'id'=>$user->id,
            'fullname'=>$user->fullname,
            'email'=>$user->email
        ];

        //trạng thái thành công
        return $this->respondWithToken($token,$data);
     
    }

    public function loginRedirectFacebook(){
        
        try {

            return Socialite::driver('facebook')->redirect();
        } catch (\Throwable $th) {
            return $this->responseApiError([], 'Cant`t login facebook');
        }
    }

    public function loginCallbackFacebook(){
        
        try {
            $facebookUser = Socialite::driver('facebook')->user();

        } catch (\Throwable $th) {
            
            return $this->responseApiError([], 'Cant`t login facebook');
        }        

        // Tìm kiếm người dùng dựa trên email hoặc tạo mới
        $user = Users::firstOrCreate(
            [
                'email' => $facebookUser->email ?? rand(11199,9999).'_facebook@facebook.com',
                'social'=>'facebook'
            ],
            [
                'active' => 1,
                'fullname' => $facebookUser->name,
                'password' => Hash::make($facebookUser->email ?? rand(11199,9999).'_facebook@facebook.com')
            ]
        );

        // Tạo JWT
        $token = Crypt::encryptString(json_encode($user));

        if(empty($token)){

            return $this->responseApiError([], 'Cant`t create token facebook');
        }

        $data = [
            'id'=>$user->id,
            'fullname'=>$user->fullname,
            'email'=>$user->email
        ];

        //trạng thái thành công
        return $this->respondWithToken($token,$data);
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

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    
    protected function respondWithToken($token,$data)
    {   
        $dataRespon = [
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in' => config('jwt.ttl'),
            'infor'=>$data ?? []
        ];

        //trạng thái thành công
        return $this->responseApiSuccess($dataRespon);
    }
    
    //create infor when login social
    public function createInforSocial(Request $request){

        $data = $request->only(['address','birthday','fullname']);

        $validator = [
            'address' => ['string','min:0'],
	        'birthday'=>['date_format:Y-m-d'],
	        'fullname'=>['string','min:0']
        ];

        $validator = Validator::make($data, $validator);

        // validate data
        if ($validator->fails()) {

            return $this->responseApiError([], $validator->messages()->first());
        }

        if(empty($data)){

            return $this->responseApiError([], 'Empty data input');
        }

        $user = Auth::user();
        
        try {
             
            // Cập nhật thông tin người dùng từ dữ liệu mới
            $user->update($data);

            return $this->responseApiSuccess($data);

        } catch (\Throwable $th) {

            return $this->responseApiError([], 'Exception update user');
        }
        
    }
}
