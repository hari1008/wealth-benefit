<?php

/*
 * File: TransactionServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class TransactionServiceProvider extends ServiceProvider
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
         $this->app->bind('App\Contracts\TransactionContract', function() {
            return new \App\Implementers\TransactionContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\TransactionContract'];
    }
}
