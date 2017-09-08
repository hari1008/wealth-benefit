<?php

/*
 * File: HealthProviderServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class WorkServiceProvider extends ServiceProvider
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
         $this->app->bind('App\Contracts\WorkContract', function() {
            return new \App\Implementers\WorkContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\WorkContract'];
    }
}
