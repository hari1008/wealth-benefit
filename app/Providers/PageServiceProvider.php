<?php

/*
 * File: PageServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class PageServiceProvider extends ServiceProvider
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
         $this->app->bind('App\Contracts\PageContract', function() {
            return new \App\Implementers\PageContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\PageContract'];
    }
}
