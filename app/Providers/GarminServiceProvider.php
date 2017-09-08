<?php

/*
 * File: HealthProviderServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class GarminServiceProvider extends ServiceProvider
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
         $this->app->bind('App\Contracts\GarminContract', function() {
            return new \App\Implementers\GarminContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\GarminContract'];
    }
}
