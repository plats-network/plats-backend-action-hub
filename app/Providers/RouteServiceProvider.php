<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $env = env('APP_ENV');
            $host = request()->getHttpHost();

            if ($env == 'cws' || $host == 'cws.plats.network') {
                Route::middleware([])->group(base_path('routes/admin.php'));
            }

            if ($env == 'event' || $host == 'event.plats.network') {
                Route::middleware([])->group(base_path('routes/web.php'));
            }

            Route::middleware(['web'])
                ->prefix('auth')
                ->group(base_path('routes/auth.php'));

            Route::prefix('api')
                ->middleware(['api', 'auth:api', 'debug.api'])
                ->group(base_path('routes/api.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
