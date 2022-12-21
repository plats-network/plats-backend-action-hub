<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Required config menus
     *
     * @var bool
     */
    protected $bootedAppMenu = false;

    /**
     * Check booted composer
     *
     * @var bool
     */
    protected $bootedComposer = false;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.use_ssl', false)) {
            URL::forceScheme('https');
        }

        Blade::componentNamespace('App\View\Components\Forms', 'form');
        Blade::anonymousComponentNamespace('admin._components', 'admin');

        /**
         * DO: Boot menus
         */
        /*view()->composer('*', function () {
            if ($this->bootedComposer == true) {
                return true;
            }

            $this->addMenuHelper();

            $this->bootedComposer = true;

            return true;
        });*/
    }

    /**
     * Get config files menu
     *
     * @return bool
     */
    protected function addMenuHelper(): bool
    {
        if ($this->bootedAppMenu || request()->expectsJson() || Auth::guest()) {
            return true;
        }

        $menuFiles = glob(app_path('Helpers/Menus/*.php'));
        foreach ($menuFiles as $file) {
            require $file;
        }

        $this->bootedAppMenu = true;

        return true;
    }
}
