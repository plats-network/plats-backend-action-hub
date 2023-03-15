<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterConfirmRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Jobs\SendRegisterEmail;
use App\Jobs\SendWelcomeEmail;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Register extends Controller
{
    /**
     * @var \App\Services\UserService
     */
    protected UserService $userService;

    /**
     * @param \App\Services\UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param \App\Http\Requests\Auth\RegisterRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->userService->findByEmail($request->input('email'));

            if($user) {
                if(!is_null($user->email_verified_at)) {
                    return $this->respondError('Email not active!', 400, ACCOUNT_ACTIVED);
                } else {
                    if (!$this->isExpired($user)) {
                        return $this->respondError('Please check confirmation code', 400, TIME_INVALID);
                    }
                }
            }

            $userCreated = new UserResource($this->userService->createOrUpdate($request));

            if ($userCreated) {
                dispatch(new SendRegisterEmail($userCreated));
            }
        } catch (\Exception $e) {
            return $this->respondError('Error server', 500);
        }

        return $this->respondSuccess('Please check email confirm ' . $userCreated->email);
    }

    /**
     * @param RegisterConfirmRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function confirmEmail(RegisterConfirmRequest $request) {
        try {
            $user = $this->userService->confirmEmail($request);

            if (!$user) {
                return $this->respondError('User not found.', 400, CONFIRM_CODE_INVALID);
            }

            dispatch(new SendWelcomeEmail($user));
        } catch (\Exception $e) {
            return $this->respondError('Error system!', 500);
        }

        return $this->respondSuccess('Confirmation dome.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function resendOtp(Request $request)
    {
        try {
            $this->validateEmailUnique($request);

            $user = new UserResource($this->userService->findByEmail($request->only('email')));
            if(!is_null($user->email_verified_at)) {
                return $this->respondError('Your account has been activated.', 400, ACCOUNT_ACTIVED);
            }

            if (!$this->isExpired($user)) {
                return $this->respondError('Please wait 10 minutes from the time of sending the mail.', 400, TIME_INVALID);
            }

            if ($user) {
                $user = $this->userService->updateConfirmationCode($request->only('email'));
                dispatch(new SendRegisterEmail($user));
            }
        } catch (\Exception $e) {
            return $this->respondError('Error system!', 500);
        }

        return $this->respondSuccess('Send code done ' . $user->email);
    }

    /**
     * Check expiration date
     *
     * @param  $model
     * @return Boolean
     */
    public function isExpired($model)
    {
        return $model
            ? Carbon::parse($model->updated_at)->addMinutes(10)->isPast()
            : false;
    }

    /**
     * Validate email unique
     *
     * @param  $request
     */
    public function validateEmailUnique($request)
    {
        return $request->validate(['email' => ['required', 'max:' . INPUT_MAX_LENGTH, 'email', 'exists:users,email']]);
    }
}
