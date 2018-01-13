<?php

namespace Sujip\Middleware;

use Illuminate\Support\ServiceProvider;

/**
 * Class PreferredDomainServiceProvider
 * @package Sujip\Middleware
 */
class PreferredDomainServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/domain.php' => config_path('domain.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/domain.php', 'domain');
    }
}
