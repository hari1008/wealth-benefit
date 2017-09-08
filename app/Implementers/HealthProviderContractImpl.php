<?php

/*
 * File: HealthProviderContractImpl.php
 */

namespace App\Implementers;
use App\Contracts\HealthProviderContract;
use App\Implementers\BaseImplementer;
use App\Models\MasterHealthProvider;
use App\Models\UserHealthProvider;
use App\Helper\Utility\UtilityHelper;
use Symfony\Component\HttpFoundation\Response;

class HealthProviderContractImpl extends BaseImplementer implements HealthProviderContract {
    
    public function __construct() {
    }
    
    /**
        * 
        * Provide list of health providers of the behalf of type
        * 
        * @param $data contains type of health providers
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with health provider objects if retrieved device data successfully
        * 
    */
    public function getHealthProviders($data) {
        try{ 
            $healthProviders = MasterHealthProvider::getHealthProviders($data->input('type'));
            return $this->renderSuccess(trans('messages.health_providers_insurance_lists_retrieved'),$healthProviders);
        } 
        catch(\Exception $e){
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    
    /**
        * 
        * Does entry of user with Health provider when user show interest in Health Provider 
        * 
        * @param $data contains information of health Provider in which users shows his interest
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with object if successfully entered the data with respect to the Health Provider  failure otherwise
        * 
    */
    public function postShowIntrest($data) {
        try{ 
            $healthProviders = UserHealthProvider::updateInterestedUserData($data);
            if(is_object($healthProviders)){
                return $this->renderSuccess(trans('messages.user_interested_in_provider'),$healthProviders);
            }
            else{
                return $this->model_not_found_error(trans('messages.common_error'));
            }
        } 
        catch(\Exception $e){
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    
}    