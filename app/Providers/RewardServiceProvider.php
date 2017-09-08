<?php

/*
 * File: RewardServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class RewardServiceProvider extends ServiceProvider
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
         $this->app->bind('App\Contracts\RewardContract', function() {
            return new \App\Implementers\RewardContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\RewardContract'];
    }
}
