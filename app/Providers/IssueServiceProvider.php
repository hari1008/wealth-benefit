<?php

/*
 * File: IssueServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class IssueServiceProvider extends ServiceProvider
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
         $this->app->bind('App\Contracts\IssueContract', function() {
            return new \App\Implementers\IssueContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\IssueContract'];
    }
}
