<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use App\Models\Beta\User\Users;
use App\Http\Controllers\Controller;

class DecryptTokenMiddleware
{
    public function handle($request, Closure $next)
    {

		try {

	        // Kiểm tra xem header Authorization có tồn tại không
	        if ($request->header('Authorization')) {

	            // Lấy token từ header Authorization
	            $encryptedToken = $request->header('Authorization');

	            $encryptedToken = str_replace('Bearer ', '', $encryptedToken);

	            // Giải mã token
	            $decryptedToken = json_decode(Crypt::decryptString($encryptedToken), true);

                if(empty($decryptedToken)){

                    return (new Controller())->responseApiError([], 'Error bearer token');

                }
                
                $userModelInstance = Users::find($decryptedToken['id']); // Tìm kiếm hoặc tạo một đối tượng người dùng
               
                //account block
                if(!$userModelInstance){

                    return (new Controller())->responseApiError([], 'undefined token');
                }

                //account block
                if($userModelInstance['active'] != 1){

                    return (new Controller())->responseApiError([], 'Your account is blocked');
                }
                
                Auth::login($userModelInstance);

	            return $next($request);
	        }
            
            return (new Controller())->responseApiError([], 'Error bearer token');

	    } catch (DecryptException $e) {

            return (new Controller())->responseApiError([], 'Unauthorized');
		}
    }
}