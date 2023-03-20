<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Resources\SocialResource;
use App\Models\{Event\EventUserTicket, User as UserModel, Task};
use App\Exports\Ticket;
use App\Jobs\SendTicket;

class User extends ApiController
{
    public function __construct (
        private UserModel $user,
        private Task $task
    )
    {
        // code auth
    }

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

    public function getTicket($id, Request $request)
    {
        try {
            $user = $request->user();
            $user->update(['email' => 'dovv1987+1001@gmail.com']);
            $task = $this->task->findOrFail($id);

            if ($user){
                $userTicket = EventUserTicket::where('user_id', $user->id)->first();
                if ($userTicket) {
                    dispatch(new SendTicket($task, $user->email, $user));
                }
            }
        } catch (\Exception $e) {
            return $this->respondError("Errors {$e->getMessage()}");
        }

        return $this->responseMessage('Vé đã được gửi về email của bạn');
    }
}
