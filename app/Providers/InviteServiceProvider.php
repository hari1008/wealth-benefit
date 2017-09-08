<?php

/*
 * File: InviteServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class InviteServiceProvider extends ServiceProvider
{
     protected $defer = true;
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->app->bind('App\Helper\Contracts\UserContract', function() {
//            return new \App\Helpers\Implementers\UserContractImpl();
//        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         $this->app->bind('App\Contracts\InviteContract', function() {
            return new \App\Implementers\InviteContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\InviteContract'];
    }
}
