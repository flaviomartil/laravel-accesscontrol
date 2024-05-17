<?php

namespace FlavioMartil\AccessControl\AccessControl;

use Illuminate\Support\ServiceProvider;

class AccessControlProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        // Publish the configuration file during package boot
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/accesscontrol.php' => config_path('accesscontrol.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../assets/migrations/' => database_path('migrations'),
            ], 'migrations');

        }


    }
}
