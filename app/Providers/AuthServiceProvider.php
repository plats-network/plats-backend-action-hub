<?php

namespace App\Providers;

use App\Guards\JwtGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('jwt', function ($app, $name, array $config) {
            unset($name);
            // Return an instance of Illuminate\Contracts\Auth\Guard...
            $guard = new JWTGuard(
                $app['tymon.jwt'],
                $app['auth']->createUserProvider($config['provider']),
                $app['session.store'],
                $app['request'],
                $app['events']
            );

            $app->refresh('request', $guard, 'setRequest');

            return $guard;
        });

        Auth::provider('token', function ($app, array $config) {
            return new PlatsUserProvider();
        });

        /*if (! $this->app->routesAreCached()) {
            Passport::routes();
        }*/
    }
}
