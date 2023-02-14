<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Resources\SocialResource;
use App\Models\User as UserModel;

class User extends ApiController
{
    public function __construct(private UserModel $user)
    {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAccountSocial(Request $request)
    {
        try {
            $userId = $request->user()->id;
            $infoUser = $this->user->find($userId);
        } catch (\Exception $e) {
            return $this->respondError("Errors {$e->getMessage()}");
        }

        return $this->respondWithResource(new SocialResource($infoUser), 'Social info');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAccount(Request $request)
    {
        try {
            $user = $request->user();
            $user->email = $user->id . '-'. $user->email;
            $user->save();
            $user->delete();
        } catch (\Exception $e) {
            return $this->respondError("Errors {$e->getMessage()}");
        }

        return $this->responseMessage('Delete account successful!');
    }
}
