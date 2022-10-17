<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Str;

class Authenticate extends Middleware
{
    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        $this->unauthenticated($request, $guards);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
    protected function redirectTo($request)
    {
        abort_if($request->expectsJson(), 403, 'Unauthenticated');

        if (Str::contains($request->fullUrl(), '/cp')) {
            return route(LOGIN_ADMIN_ROUTE);
        }

        return route('login');
    }

    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        // if ($request->segment(1) == 'cp' && is_null($this->auth->user())) {
        //     return route(LOGIN_ADMIN_ROUTE);
        // }

        if ($request->path() == 'api/task_notices') {
            return true;
        }

        // abort(response()->json([
        //     'success' => false,
        //     'message' => 'Unauthenticated',], 401));
    }
}
