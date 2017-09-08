<?php

/*
 * File: HealthDeviceServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class HealthDeviceServiceProvider extends ServiceProvider
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
         $this->app->bind('App\Contracts\HealthDeviceContract', function() {
            return new \App\Implementers\HealthDeviceContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\HealthDeviceContract'];
    }
}
