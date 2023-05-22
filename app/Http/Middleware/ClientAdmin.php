<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Log;

class ClientAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() && in_array(Auth::user()->role, [ADMIN_ROLE, CLIENT_ROLE])) {
            return $next($request);
        } else {
            notify()->error('Vui lòng đăng nhập!....');
            return redirect()->route('cws.formLogin');
        }
    }
}
