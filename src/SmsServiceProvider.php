<?php

namespace Eeappdev\SveveSms;

use Illuminate\Support\ServiceProvider;
use Eeappdev\SveveSms\Sms;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Sms::class, function ($app) {
            return new Sms($app->make('GuzzleHttp\Client'));
        });

        $this->mergeConfigFrom(__DIR__.'/../config/sveve.php', 'sveve');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/sveve.php' => config_path('sveve.php'),
        ], 'config');
    }
}