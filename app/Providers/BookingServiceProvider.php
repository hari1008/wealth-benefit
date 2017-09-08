<?php

/*
 * File: BookingServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class BookingServiceProvider extends ServiceProvider
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
         $this->app->bind('App\Contracts\BookingContract', function() {
            return new \App\Implementers\BookingContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\BookingContract'];
    }
}
