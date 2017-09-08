<?php

/*
 * File: HealthProviderController.php
 */


namespace App\Http\Controllers;
use App\Contracts\HealthProviderContract;
use App\Http\Requests\HealthProvider\ShowInterestRequest;
use App\Http\Requests\HealthProvider\HealthProviderListRequest;


class HealthProviderController extends BaseController {
    protected $healthProvider;
    public function __construct(HealthProviderContract $healthProvider) {
        parent::__construct();
        $this->healthProvider = $healthProvider;
        $this->middleware('jsonvalidate',['except' => ['getHealthProviderList']]);
    }
   
    /**
        * 
        * Provide list of health providers of the behalf of type
        * 
        * @param $request contains type of health providers
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with health provider objects if retrieved device data successfully
        * 
    */
    public function getHealthProviderList(HealthProviderListRequest $request) {
        return $this->healthProvider->getHealthProviders($request);
    }
    
     /**
        * 
        * Does entry of user with Health provider when user show interest in Health Provider 
        * 
        * @param $request contains information of health Provider in which users shows his/her interest
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with object if successfully entered the data with respect to the Health Provider  failure otherwise
        * 
    */
    public function postUserShowIntrest(ShowInterestRequest $request) {
        return $this->healthProvider->postShowIntrest($request);
    }
    
}
