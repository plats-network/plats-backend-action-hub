<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Resources\SocialResource;
use App\Models\{Event\EventUserTicket, User as UserModel, Task};
use App\Exports\Ticket;

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
            $task = $this->task->findOrFail($id);
            if ($user){
                $userTicket = EventUserTicket::where('user_id',$user->id)->first();
                // TODO: Send mail
                return (new Ticket($task,$userTicket))->downloadPdf();
            }
        } catch (\Exception $e) {
            return $this->respondError("Errors {$e->getMessage()}");
        }
        return $this->respondError('Ticket not found', 404);
    }
}
