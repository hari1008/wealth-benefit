<?php

/*
 * File: NotificationServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class QualificationServiceProvider extends ServiceProvider
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
         $this->app->bind('App\Contracts\QualificationContract', function() {
            return new \App\Implementers\QualificationContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\QualificationContract'];
    }
}
