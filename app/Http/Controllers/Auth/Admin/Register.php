<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\RegisRequest;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class Register extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisRequest $request)
    {
        try {
            $res = Http::post(config('app.api_user_url') . '/api/register_admin', [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            $code = $res->getStatusCode();
            $user = json_decode($res->getBody()->getContents());
            if ($code == 200 && optional($user)->user) {
                return redirect('auth/cws')->with('message', 'Tạo tài khoản thành công');
            }
        } catch (Exception $exception) {
            return redirect('cws/register')->withErrors(['message' => 'Error: Liên hệ admim']);
        }

        return redirect('cws/register')->withErrors(['message' => 'Tài khoản đã tồn tại']);
    }
}
