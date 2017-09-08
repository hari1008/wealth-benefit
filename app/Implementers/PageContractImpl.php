<?php

/*
 * File: PageContractImpl.php
 */

namespace App\Implementers;
use App\Contracts\PageContract;
use App\Implementers\BaseImplementer;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use App\Helper\Utility\UtilityHelper;
use Symfony\Component\HttpFoundation\Response;
use App\Codes\Constant;
use App\Models\MasterWorks;
use App\Models\MasterEcosystem;
use App\Models\MasterHealthProvider;

class PageContractImpl extends BaseImplementer implements PageContract {
    
    public function __construct() {
        
    }
    
    /**
        * 
        * Will bring terms and conditions data
        * 
        * @param NULL
        * 
        * @throws Exception If something happens during the process
        * 
        * @return terms and conditions data
        * 
    */
    public function getTermsCondition() {
        try {
            $settingData = Setting::getData(Config::get('constants.setting.terms'));
            $data = !empty($settingData) ? $settingData['description'] : '';
            return $this->renderSuccess(trans('messages.t_c_data_successfully_retrieved'), [$settingData]);
        } catch (\Exception $e) {
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
            }
    }
    
    /**
        * 
        * Will bring partners data
        * 
        * @param NULL
        * 
        * @throws Exception If something happens during the process
        * 
        * @return partners data
        * 
    */
    public function getPartners($data) {
        try {
            $partners = [];
            if($data['type'] == Constant::$PARTNERS_TYPE['Gyms'] || $data['type'] == Constant::$PARTNERS_TYPE['HealthGroups'] || $data['type'] == Constant::$PARTNERS_TYPE['Hotels'] || $data['type'] == Constant::$PARTNERS_TYPE['Government']){
                $partners = MasterWorks::getWorksLogo($data['type']);
            }
            else if($data['type'] == Constant::$PARTNERS_TYPE['Ecosystem']){
                $partners = MasterEcosystem::getEcosystemLogo();
            }
            else if($data['type'] == Constant::$PARTNERS_TYPE['HealthProvider']){
                $partners = MasterHealthProvider::getProviderLogo(Constant::$HEALTH_PROVIDER);
            }
            else if($data['type'] == Constant::$PARTNERS_TYPE['InsuranceProvider']){
                $partners = MasterHealthProvider::getProviderLogo(Constant::$INSURANCE_PROVIDER);
            }
            return $this->renderSuccess(trans('messages.parners_successfully_retrieved'),$partners);
        } catch (\Exception $e) {
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
            }
    }
}
