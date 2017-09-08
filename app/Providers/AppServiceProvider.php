<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        Validator::extend('validatefileext', function($attribute, $value, $parameters) {
            $attribute = '';
           
            $extension = $value->getClientOriginalextension();
            return in_array($extension,$parameters) ? true :  false ;    
        });
        
        Validator::extend('alpha_spaces', function($attribute, $value)
        {
            return preg_match('/^[\pL\s]+$/u', $value);
        });
        Validator::extend('url_validate', function($attribute, $value)
        {
            return preg_match("/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/i", $value);
        });
        Validator::extend('less_than', function($attribute, $value,$parameters,$validator)
        {
            
            $start = strtotime($value);
           
            $closing_hrs = array_get($validator->getData(), $parameters[0], null);
           
            $end = strtotime($closing_hrs);
           
            return $start < $end ? true : false;
            
        });
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
