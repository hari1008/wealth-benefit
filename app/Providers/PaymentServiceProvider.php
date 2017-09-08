<?php

/*
 * File: HealthProviderServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
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
         $this->app->bind('App\Contracts\PaymentContract', function() {
            return new \App\Implementers\PaymentContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\PaymentContract'];
    }
}
