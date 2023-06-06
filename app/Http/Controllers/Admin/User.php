<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Helpers\{BaseImage, DateHelper};
use App\Services\UserService;
use App\Models\{
    User as UserModel
};
use Illuminate\Http\Request;
use App\Http\Requests\Cws\{
    EditEmailRequest,
    EditInfoRequest,
    EditPasswordRequest,
};
use Illuminate\Support\Facades\{
    Session, Auth, Hash, Storage, DB, Log
};
use Carbon\Carbon;

class User extends Controller
{
    public function __construct(
        private UserService $userService,
        private UserModel $user,
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

    // public function apiListUser(Request $request)
    // {
    //     $users = $this->userService->search(['limit' => $request->get('limit') ?? PAGE_SIZE]);
    //     return  response()->json($users);
    // }

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
            // TODO: Send Email verify
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
            dd($e->getMessage());
            notify()->error('Lỗi cập nhật');
            return redirect()->route('cws.setting');
        }

        return redirect()->route('cws.setting');
    }
}
