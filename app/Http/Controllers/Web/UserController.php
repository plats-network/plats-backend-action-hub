<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Log;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Event\EventUserTicket;

class UserController extends Controller
{
    public function __construct(
        private User $user,
        private EventUserTicket $ticket,
    )
    {
        // code
    }

    public function profile(Request $request)
    {
        try {
            $user = Auth::user();

            if ($user && $user->role != USER_ROLE) {
                Auth::login($user);
            }
        } catch (\Exception $e) {
            notify()->error('Có lỗi xảy ra');
            Log::error('Errors: '. $e->getMessage());

            return redirect()->route('web.home');
        }

        return view('web.user.profile', [
            'user' => $user,
        ]);
    }

    public function editEmail(Request $request)
    {
        try {
            // controller@formidium.com

            $user = Auth::user();
            $taskId = $request->input('task_id');
            $email = Str::lower($request->input('email'));
            $name = $request->input('name');

            $oldUser = User::whereRaw('lower(email) = ? ', [$email])->first();

            if (Str::lower($user->email) == $email) {
                notify()->error('Duplicate current email account');

                return redirect()->route('job.getTravelGame', [
                    'task_id' => $taskId
                ]);
            }

            // dd($oldUser);

            if ($oldUser) {
                $oldUser->update(['email' => Carbon::now()->timestamp.'_'.$email]);
                notify()->success('Update email successfully');
            } else {
                $user->update([
                    'name' => $name,
                    'email' => $email
                ]);
                notify()->success('Update email successfully');
            }

            if (session()->get('u-'.$user->id)) {
                session()->forget('u-'.$user->id);
            }
            $user->update(['name' => $name,'email' => $email]);

            $ticket = $this->ticket
                ->whereUserId(optional($oldUser)->id)
                ->whereTaskId($taskId)
                ->first();
            
            if ($ticket) {
                if ($ticket->is_vip) {
                    $ticket->update([
                        'is_vip' => true,
                        'email' => $email
                    ]);
                } else {
                    $ticket->update([
                        'is_vip' => false,
                        'email' => $email
                    ]);
                }
            }
        } catch (\Exception $e) {
            notify()->error('Lỗi: '.$e->getMessage());
            return redirect()->route('job.getTravelGame', [
                'task_id' => $taskId
            ]);
        }

        return redirect()->route('job.getTravelGame', [
            'task_id' => $taskId
        ]);
    }
}
