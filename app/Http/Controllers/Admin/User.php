<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Helpers\{BaseImage, DateHelper};
use App\Services\UserService;
use App\Models\{User as UserModel, Task};
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Event\{EventUserTicket, UserCode, TaskEvent};
use App\Http\Requests\Cws\{
    EditEmailRequest,
    EditInfoRequest,
    EditPasswordRequest,
};
use Illuminate\Support\Facades\{
    Session, Auth, Hash, Storage, DB, Log
};
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Exports\UserList;

class User extends Controller
{
    public function __construct(
        private UserService $userService,
        private UserModel $user,
        private Task $task,
        private TaskEvent $taskEvent,
        private UserCode $userCode,
        private EventUserTicket $eventUserTicket,
    ) {
        // Code
    }

    public function index(Request $request)
    {
        $users = $this->userService->search([
            'limit' => $request->get('limit') ?? PAGE_SIZE
        ]);

        return view('cws.users.index', [
            'users' => $users
        ]);
    }


    public function saveUserByEvent(Request $request)
    {
        try {
            $email = $request->input('email');
            $name = $request->input('name');
            $taskId = $request->input('task_id');
            $vip = $request->input('vip') == 1 ? true : false;
            $user = $this->user->whereEmail($email)->first();

            if ($user) {
                $ticket = $this->eventUserTicket
                    ->whereTaskId($taskId)
                    ->whereUserId($user->id)
                    ->first();

                if ($ticket) {
                    $ticket->update(['is_vip' => $vip]);
                } else {
                    $this->eventUserTicket->create([
                        'name' => $name ?? 'No Name',
                        'phone' => $user->phone ?? '0955435345',
                        'email' => $email,
                        'task_id' => $taskId,
                        'user_id' => $user->id,
                        'is_checkin' => true,
                        'hash_code' => Str::random(35),
                        'is_vip' => $vip
                    ]);
                }
            } else {
                $user = $this->user->create([
                    'name' => $name,
                    'email' => $email,
                    'password' => '123456a@',
                    'phone' => '0932842323',
                    'role' => GUEST_ROLE,
                    'confirm_at' => now(),
                    'status' => USER_CONFIRM
                ]);

                $this->eventUserTicket->create([
                    'name' => $name ?? 'No Name',
                    'phone' => "09348324098",
                    'email' => $email,
                    'task_id' => $taskId,
                    'user_id' => $user->id,
                    'is_checkin' => true,
                    'hash_code' => Str::random(35),
                    'is_vip' => $vip
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error'
            ], 500);
        }

        return response()->json([
            'message' => 'Ok'
        ], 200);
    }

    public function listUsers(Request $request, $id)
    {
        try {
            $userIds = $this->eventUserTicket->select('user_id')->whereTaskId($id);
            if ($request->input('vip')) {
                $vip = $request->input('vip') == 1 ? 0 : 1;
                $userIds = $userIds->where('is_vip', $vip);
            }
            $userIds = $userIds->pluck('user_id')->toArray();
            $userIds = array_unique($userIds);
            $users = $this->userService->search([
                'limit' => $request->get('limit') ?? PAGE_SIZE,
                'userIds' => $userIds
            ]);
        } catch (\Exception $e) {
            
        }

        return view('cws.users.list', [
            'users' => $users,
            'id' => $id
        ]);
    }

    public function listMax(Request $request, $taskId)
    {
        try {
            // if ($taskId == '9a23915f-07ae-4278-ba9d-bb8f11b46663') {
            //     $users = $this->user->whereDate('created_at', '=', date('Y-m-d'))->get();

            //     foreach($users as $user) {
            //         $aCheck = $this->eventUserTicket->whereUserId($user->id)->whereTaskId($taskId)->exists();
            //         if (!$aCheck) {
            //             $this->eventUserTicket->create([
            //                 'user_id' => $user->id,
            //                 'task_id' => $taskId,
            //                 'name' => $user->name,
            //                 'phone' => $user->phone ?? '098432323',
            //                 'email' => $user->email,
            //                 'is_checkin' => true,
            //                 'hash_code' => Str::random(32),
            //                 'created_at' => $user->created_at
            //             ]);
            //         }
            //     }
            // }

            $type = $request->input('type');

            if ($type && $type == 1) {
                $userCodes = $this->eventUserTicket
                    ->with('task', 'user')
                    ->whereTaskId($taskId)
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
                $total = $this->eventUserTicket
                    ->with('task', 'user')
                    ->whereTaskId($taskId)
                    ->count();
            } elseif($type && $type == 2) {
                $userCodes = $this->eventUserTicket
                    ->with('task', 'user')
                    ->whereTaskId($taskId)
                    ->orderBy('created_at', 'desc')
                    ->get();

                return Excel::download(new UserList($userCodes), 'user-join-event.xlsx');
            } else {
                $ids = $this->taskEvent->whereTaskId($taskId)
                    ->pluck('id')->toArray();

                $userCodes = $this->userCode
                    ->with('user', 'taskEvent', 'travelGame')
                    ->distinct()
                    ->whereIn('task_event_id', $ids)
                    ->orderBy('number_code', 'asc')
                    ->limit(200)
                    ->get();

                $total = $this->userCode
                    ->with('user', 'taskEvent', 'travelGame')
                    ->distinct()
                    ->whereIn('task_event_id', $ids)
                    ->count();
            }

        } catch (\Exception $e) {
            abort(404);
        }

        return view('cws.users.list_max', [
            'userCodes' => $userCodes,
            'id' => $taskId,
            'total' => $total
        ]);
    }

    // Get setting client user
    // Method: GET
    // Url: /setting
    public function setting(Request $request)
    {
        $type = session()->get('type');
        $user = Auth::user();

        return view('cws.profiles.index', [
            'user' => $user,
            'avatar' => BaseImage::imgGroup($user->avatar_path),
            'flagEmail' => $type && $type == 'edit-email' ? true : false,
            'flagPass' => $type && $type == 'edit-pass' ? true : false,
            'flagInfo' => $type && $type == 'edit-info' ? true : false,
            'flag' => empty($type) ? true : false,
        ]);
    }

    // Change password for user client
    // Method: POST
    // Url: /change-password
    public function changePassword(EditPasswordRequest $request)
    {
        try {
            $user = Auth::user();

            if (!Hash::check($request->input('old'), $user->password)) {
                notify()->error("Old Password Doesn't match!");
                return redirect()->route('cws.setting');
            }

            $user->update([
                'password' => $request->input('password')
            ]);
            notify()->success('Change password successfully!');
            session()->forget(['type']);
        } catch (\Exception $e) {
            Log::error('Change password: ' . $e->getMessage());
            notify()->error('Change password fail');

            return redirect()->route('cws.setting');
        }

        return redirect()->route('cws.setting');
    }

    // Change email for user client
    // Method: POST
    // Url: /change-email
    public function changeEmail(EditEmailRequest $request)
    {
        try {
            $user = Auth::user();
            $email = $request->input('email');
            $user->update([
                'new_email' => $email,
                'email' => $email
            ]);
            notify()->success('Change email successfully!');
            session()->forget(['type']);
        } catch (\Exception $e) {
            Log::error('Error change email: ' . $e->getMessage());
            notify()->error('Error system');
            return redirect()->route('cws.setting');
        }
        return redirect()->route('cws.setting');
    }

    // Change info for user client
    // Method: POST
    // Url: /change-info
    public function changeInfo(EditInfoRequest $request)
    {
        try {
            $data = $request->all();
            $user = Auth::user();

            if ($request->hasFile('avatar_path')) {
                $uploadedFile = $request->file('avatar_path');
                $path = 'user/avatars/' . Carbon::now()->format('Ymd');
                $avatar = Storage::disk('s3')->putFileAs($path, $uploadedFile, $uploadedFile->hashName());
                $user->update(['avatar_path' => $avatar]);
            }

            $user->update([
                'name' => $data['name'],
                'gender' => $data['gender'],
                'birth' => $data['birth'],
            ]);
            session()->forget(['type']);
            notify()->success('Cập nhật thành công');
        } catch (\Exception $e) {
            Log::error('Lỗi update' . $e->getMessage());
            notify()->error('Lỗi cập nhật');
            return redirect()->route('cws.setting');
        }

        return redirect()->route('cws.setting');
    }
}
