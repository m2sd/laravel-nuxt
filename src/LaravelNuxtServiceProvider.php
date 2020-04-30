<?php

namespace M2S\LaravelNuxt;

use Illuminate\Support\ServiceProvider;
use M2S\LaravelNuxt\Console\Commands\InstallCommand;

class LaravelNuxtServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/nuxt.php',
            'nuxt'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [__DIR__.'/../config/nuxt.php' => config_path('nuxt.php')],
            'config'
        );

        $this->loadViewsFrom(__DIR__.'/../views', 'nuxt');

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }

        if (config('nuxt.routing')) {
            $this->loadRoutesFrom(__DIR__.'/../routes/nuxt.php');
        }
    }
}
