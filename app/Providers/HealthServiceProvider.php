<?php

/*
 * File: HealthServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class HealthServiceProvider extends ServiceProvider
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
         $this->app->bind('App\Contracts\HealthContract', function() {
            return new \App\Implementers\HealthContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\HealthContract'];
    }
}
