<?php

/*
 * File: WalletServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class WalletServiceProvider extends ServiceProvider
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
         $this->app->bind('App\Contracts\WalletContract', function() {
            return new \App\Implementers\WalletContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\WalletContract'];
    }
}
