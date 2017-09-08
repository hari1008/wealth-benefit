<?php

/*
 * File: HighfiveServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class HighfiveServiceProvider extends ServiceProvider
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
         $this->app->bind('App\Contracts\HighfiveContract', function() {
            return new \App\Implementers\HighfiveContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\HighfiveContract'];
    }
}
