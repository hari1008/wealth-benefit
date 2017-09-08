<?php

/*
 * File: GymServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class GymServiceProvider extends ServiceProvider
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
         $this->app->bind('App\Contracts\GymContract', function() {
            return new \App\Implementers\GymContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\GymContract'];
    }
}
