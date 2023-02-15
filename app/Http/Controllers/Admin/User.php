<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class User extends  Controller
{

    public function __construct(
        private UserService $userService,
    ) {}

    public function index(Request $request)
    {
        return view(
            'admin.user.index',[
            ]
        );
    }

    public function apiListUser(Request $request)
    {
        $users = $this->userService->search(['limit' => $request->get('limit') ?? PAGE_SIZE]);
        return  response()->json($users);

    }

}
