<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\{
    ChangePasswordRequest,
    SocialRequest,
    UpdateProfileRequest
};
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\User;

class Profile extends ApiController
{
    /**
     * @param $userService
     * @param $user
     */
    public function __construct(
        private UserService $userService,
        private User $user
    ) {}

    /**
     * @param \App\Http\Requests\UpdateProfileRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return $this->respondNotFound();
        }

        return new UserResource($user);
    }

    /**
     * @param \App\Http\Requests\UpdateProfileRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function update(UpdateProfileRequest $request)
    {
        return new UserResource(
            $this->userService->update($request->merge(['id' => $request->user()->id]))
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4086',
        ]);
        $data = $this->userService->updateAvatar($request->merge(['id' => $request->user()->id]));
        
        return $this->respondWithData($data, 'Update successful');
    }

    /**
     * @param \App\Http\Requests\ChangePasswordRequest $request
     *
     * @return \App\Http\Resources\UserResource
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        return new UserResource(
            $this->userService->changePassword($request->user()->id, $request->input('password'))
        );
    }

    /**
     * @param $request
     *
     * @return \App\Http\Resources\UserResource
     */
    public function updateSocialAccount(SocialRequest $request)
    {
        try {
            $userId = $request->user()->id;
            $infoUser = $this->user->find($userId);
            $socialTweeter = $this->user->where('twitter', $request->account)->first();
            $socialFacebook = $this->user->where('facebook', $request->account)->first();
            $socialDiscord = $this->user->where('discord', $request->account)->first();
            $socialTelegram = $this->user->where('telegram', $request->account)->first();

            if ($socialTweeter) { return $this->respondError('Twitter ID is exits!', 400); }
            if ($socialFacebook) { return $this->respondError('Facebook ID is exits!', 400); }
            if ($socialDiscord) { return $this->respondError('Discord ID is exits!', 400); }
            if ($socialTelegram) { return $this->respondError('Telegram ID is exits!', 400); }

            $user = $this->userService->updateSocialAccount($userId, $request);
        } catch (\Exception $e) {
            return $this->respondError('Errors: ' . $e->getMessage());
        }


        return new UserResource($user);
    }
}
