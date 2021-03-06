<?php

/*
 * File: UserServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
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
         $this->app->bind('App\Contracts\UserContract', function() {
            return new \App\Implementers\UserContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\UserContract'];
    }
}
