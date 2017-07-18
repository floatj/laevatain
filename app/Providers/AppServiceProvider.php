<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Classes\PollingWorker as PollingWorker;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //register PollingWorker as singleton

        \App::singleton('PollingWorker', function ($app) {
            return new PollingWorker();
        });
    }
}
