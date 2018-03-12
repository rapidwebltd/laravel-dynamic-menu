<?php

namespace RapidWeb\LaravelDynamicMenu\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelDynamicMenuServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }
}
