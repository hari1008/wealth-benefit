<?php

/*
 * File: NotificationServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
     protected $defer = true;
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         $this->app->bind('App\Contracts\NotificationContract', function() {
            return new \App\Implementers\NotificationContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\NotificationContract'];
    }
}
