<?php

/*
 * File: HealthDeviceContractImpl.php
 */

namespace App\Implementers;
use App\Contracts\HealthDeviceContract;
use App\Implementers\BaseImplementer;
use App\Models\UserHealthDevices;
use App\Helper\Utility\UtilityHelper;
use App\Models\Goal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Helper\Utility\CommonHelper;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class HealthDeviceContractImpl extends BaseImplementer implements HealthDeviceContract {
    
    public function __construct() {
    }
    
    /**
        * 
        * Insert/Update health device data 
        * 
        * @param $request contains data of device which need to be update 
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if successfully updated device data 
        * 
    */
    public function putSyncHealthDevice($request) {
        try{ 
             UserHealthDevices::updateDeviceData($request);
             return $this->renderSuccess(trans('messages.health_device_updated'), []);
        } 
        catch(\Exception $e){
              UtilityHelper::logException(__METHOD__, $e);
              return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    public function putSyncHealthDevice1($request) {
        DB::beginTransaction();
        try{ 
            UserHealthDevices::updateDeviceData1($request);
            $now = new \DateTime('now');
            $year = $now->format('Y');
            $date = $now->format('Y-m-d');
            $weekNumber = CommonHelper::getWeekNumber($date); 
            $points = Goal::updateGoals(Auth::user()->user_id,(int)Auth::user()->current_tier,Auth::user()->reward_point,$date,$weekNumber);
            User::updateUserTierInfoAndPoint(Auth::user(),$weekNumber,$year,$points);
            DB::commit();
            return $this->renderSuccess(trans('messages.health_device_updated'), []);
        } 
        catch(\Exception $e){
            DB::rollback();
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    /**
        * 
        * Provide Health Device data on the basis of mode 
        * 
        * @param $request contains mode,month,year to bring data accordingly
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if retrieved device data successfully
        * 
    */
    public function getHealthDeviceData($request) {
        try{ 
            $healthDeviceData = UserHealthDevices::getDeviceData();
            return $this->renderSuccess(trans('messages.health_device_data_retrieved'), [$healthDeviceData]);
        } 
        catch(\Exception $e){
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }     
    }
    public function getHealthDeviceData1($request) {
        try{ 
            if(!empty($request['userid'])){
                $user = User::getUserById($request['userid']);
                if(!is_object($user)){
                    return $this->renderFailure(trans('messages.user_not_found'), Response::HTTP_OK);
                }
                $userId = $user['user_id'];
            }
            else{
                $userId = Auth::user()->user_id;
            }
                
            $healthDeviceData = UserHealthDevices::getDeviceData1($userId);
            return $this->renderSuccess(trans('messages.health_device_data_retrieved'), [$healthDeviceData]);
        } 
        catch(\Exception $e){
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }     
    }
    
    /**
        * 
        * Provide last sync device date or gives null if users never sync their device
        * 
        * @param NULL
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with date if retrieved device data successfully
        * 
    */
    public function getLastSyncData() {
        try{
                $healthDeviceData = UserHealthDevices::getLastSyncDate();
                return $this->renderSuccess(trans('messages.device_last_sync_retrived'), [$healthDeviceData]);
        } 
        catch(\Exception $e){
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    
    /**
        * 
        * Provide Health Device data of year 
        * 
        * @param NULL
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if retrieved device data successfully
        * 
    */
    public function getHealthDeviceDataYearly() {
        try{ 
            $now = new \DateTime('now');
            $currentYear = $now->format('Y');
            $healthDeviceData = UserHealthDevices::getDeviceDailyDataOfYear($currentYear,Auth::user()->user_id);
            return $this->renderSuccess(trans('messages.health_device_data_retrieved'),$healthDeviceData);
        } 
        catch(\Exception $e){
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }     
    }
    
    /**
        * 
        * Provide Health Device data on the hourly basis of current day 
        * 
        * @param $request contains mode,month,year to bring data accordingly
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if retrieved device data successfully
        * 
    */
    public function getCompleteDeviceData($request) {
        try{ 
            $healthDeviceData = UserHealthDevices::getCompleteDeviceData($request);
            return $this->renderSuccess(trans('messages.health_device_data_retrieved'),$healthDeviceData);
        } 
        catch(\Exception $e){
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }     
    }
    
}    