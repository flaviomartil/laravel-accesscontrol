<?php

namespace FlavioMartil\AccessControl\ServiceProvider;

use Illuminate\Support\ServiceProvider;

class AccessControlProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/accesscontrol.php' => config_path('accesscontrol.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../assets/migrations/' => database_path('migrations'),
            ], 'migrations');

            $this->publishes([
                __DIR__.'/resources/lang' => resource_path('lang/vendor/accesscontrol'),
            ], 'translations');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/accesscontrol.php', 'accesscontrol'
        );
    }
}