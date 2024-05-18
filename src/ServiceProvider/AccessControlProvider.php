<?php

namespace FlavioMartil\AccessControl\ServiceProvider;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AccessControlProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../assets/config/accesscontrol.php' => config_path('accesscontrol.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../assets/migrations/' => database_path('migrations'),
            ], 'migrations');

            $this->publishes([
                __DIR__ . '/../assets/lang/' => resource_path('lang')
            ], 'language');
        }

        $this->loadRoutes();
    }

    protected function loadRoutes()
    {
        Route::prefix(config('accesscontrol.prefix'))
            ->middleware([config('accesscontrol.middleware')])
            ->namespace('FlavioMartil\AccessControl\Controllers')
            ->group(__DIR__ . '/../assets/routes.php');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../assets/config/accesscontrol.php', 'accesscontrol'
        );
    }
}