<?php

namespace Nisha0228\Aiadapter\Providers;

use Illuminate\Support\ServiceProvider;

class AiadapterProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/adapterconfig.php', 'adapterconfig'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        //$this->loadViewsFrom(__DIR__.'/../views', 'aiadapter');
        $this->publishes([
            __DIR__.'/../config/adapterconfig.php' => config_path('adapterconfig.php'),
        ], 'config');
    }
}
