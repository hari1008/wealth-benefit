<?php

/*
 * File: HealthProviderServiceProvider.php
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class ConversationServiceProvider extends ServiceProvider
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
         $this->app->bind('App\Contracts\ConversationContract', function() {
            return new \App\Implementers\ConversationContractImpl();
        });
    }
    
    public function provides() {
        return ['App\Contracts\ConversationContract'];
    }
}
