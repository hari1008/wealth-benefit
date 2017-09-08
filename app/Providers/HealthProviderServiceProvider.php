<?php

/*
 * File: HealthProviderServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class HealthProviderServiceProvider extends ServiceProvider
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
         $this->app->bind('App\Contracts\HealthProviderContract', function() {
            return new \App\Implementers\HealthProviderContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\HealthProviderContract'];
    }
}
