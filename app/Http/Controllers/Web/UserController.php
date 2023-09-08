<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Log;
use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct(private User $user)
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

            $oldUser = $this->user
                ->whereNotIn('email', [$user->email])
                ->whereEmail($request->input('email'))
                ->first();

            if ($oldUser) {
                $oldUser->update([
                    'status' => USER_DELETED,
                    'email' => Carbon::now()->timestamp . '-'.$oldUser->email,
                    'deleted_at' => now(),
                ]);
                $user->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email')
                ]);
                notify()->success('Update email successfully');
            } else {
                $user->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email')
                ]);
                notify()->success('Update email successfully');
            }

        } catch (\Exception $e) {
            return redirect()->route('web.home');
        }

        return redirect()->route('job.getTravelGame', [
            'task_id' => $taskId
        ]);
    }
}
