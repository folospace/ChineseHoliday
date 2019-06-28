<?php

namespace Folospace\ChineseHoliday;

use Illuminate\Support\ServiceProvider;

class ChineseHolidayServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'folospace');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'folospace');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/chineseholiday.php', 'chineseholiday');

        // Register the service the package provides.
        $this->app->singleton('chineseholiday', function ($app) {
            return new ChineseHoliday;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['chineseholiday'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/chineseholiday.php' => config_path('chineseholiday.php'),
        ], 'chineseholiday.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/folospace'),
        ], 'chineseholiday.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/folospace'),
        ], 'chineseholiday.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/folospace'),
        ], 'chineseholiday.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
