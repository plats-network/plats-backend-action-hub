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
            $user = Auth::user();
            $taskId = $request->input('task_id');
            $email = Str::lower($request->input('email'));
            $name = $request->input('name');
            $type = $request->input('user_type');

            $oldUser = User::whereRaw('lower(email) = ? ', [$email])->first();

            if ($type && $type == 2) {
                $pInfo = [
                    'name' => $name,
                    'phone' => $request->input('phone'),
                    'age' => $request->input('age'),
                    'position' => $request->input('position'),
                    'organization' => $request->input('organization'),
                ];

                if ($user->email != $email && !$oldUser) {
                    $pInfo = array_merge($pInfo, ['email' => $email]);
                }
                if (session()->get('u-'.$user->id)) {
                    session()->forget('u-'.$user->id);
                }
                $user->update($pInfo);
            }

            if ($type && $type == 1) {
                $pInfo = ['name' => $name];

                if ($user->email != $email && !$oldUser) {
                    $pInfo = array_merge($pInfo, ['email' => $email]);
                }

                $user->update($pInfo);
            }

            // TODO: Event Apac 2023
            // $oldId = optional($oldUser)->id;
            // $ticket = $this->ticket
            //     ->whereUserId($oldId)
            //     ->whereTaskId($taskId)
            //     ->first();
            // $tt = $this->ticket
            //     ->whereUserId(optional($user)->id)
            //     ->whereTaskId($taskId)
            //     ->first();

            // if (Str::lower($user->email) == $email) {
            //     notify()->error('Duplicate current email account');

            //     return redirect()->route('job.getTravelGame', [
            //         'task_id' => $taskId
            //     ]);
            // }

            // if ($oldUser) {
            //     notify()->success('Update email successfully');
            //     $oldUser->update(['email' => 'delete_'.Carbon::now()->timestamp.$oldUser->email]);
            //     $user->update(['name' => $name]);

            //     return redirect()->route('u.Vip', [
            //         'email' => $email,
            //         'task_id' => $taskId
            //     ]);
            // } else {
            //     $user->update([
            //         'name' => $name,
            //         'email' => (string)$email
            //     ]);
            //     notify()->success('Update email successfully');
            // }

            if (session()->get('u-'.$user->id)) {
                session()->forget('u-'.$user->id);
            }
            
            // if ($ticket) {
            //     $tt = $this->ticket
            //         ->whereUserId(optional($user)->id)
            //         ->whereTaskId($taskId)
            //         ->first();
            //     if ($tt) {
            //         $tt->update(['is_vip' => $ticket->is_vip]);
            //     }
            // }

            // End Event Apac 2023
        } catch (\Exception $e) {
            notify()->error('Lỗi: '.$e->getMessage());
            return redirect()->route('job.getTravelGame', [
                'task_id' => $taskId
            ]);
        }

        notify()->success('Update email successfully');
        return redirect()->route('job.getTravelGame', [
            'task_id' => $taskId
        ]);
    }

    public function upVip(Request $request)
    {
        try {
            $user = Auth::user();
            $email = $request->input('email');
            $taskId = $request->input('task_id');

            $user->update(['email' => $email]);
            notify()->success('Update email successfully');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('job.getTravelGame', [
                'task_id' => '9a131bf1-d41a-4412-a075-599e97bf6dcb'
            ]);
        }

        return redirect()->route('job.getTravelGame', [
            'task_id' => $taskId
        ]);
    }
}

