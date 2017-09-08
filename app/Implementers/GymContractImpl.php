<?php

/*
 * File: GymContractImpl.php
 */

namespace App\Implementers;
use App\Contracts\GymContract;
use App\Implementers\BaseImplementer;
use Illuminate\Support\Facades\Auth;
use App\Models\UserGym;
use App\Helper\Utility\UtilityHelper;
use App\Models\MasterBeacon;
use Symfony\Component\HttpFoundation\Response;
use App\Codes\Constant;
use App\Models\UserHealthDevices;
use App\Helper\Utility\CommonHelper;
use App\Models\Goal;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\MasterEcosystem;
use App\Models\MasterGym;

class GymContractImpl extends BaseImplementer implements GymContract {
    
    public function __construct() {
        
    }
    
    /**
        * 
        * Does check in of user in gym 
        * 
        * @param $data contains information of gym beacons
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with all registered beacons of gym if successfully checkout and failure otherwise
        * 
    */
    public function postUserCheckIn($data){
        try{
            if(Auth::user()->user_type == Constant::$PLUS_USER){
                $workIds = MasterEcosystem::getEcosystemWorks(Auth::user()->ecosystem_id); 
                $gymIds = MasterGym::getGymIdsbyWork($workIds);
            }    
            else{
                $gymIds = MasterGym::getAllGymIds();
            }
            $beacons = MasterBeacon::searchForBeacons($data,$gymIds);
            if(is_object($beacons)){
                // check for user eco-system
                $userGym = UserGym::getCheckInDetials($beacons['master_gym_id'],Auth::user()->user_id);
                if(!empty($userGym['checkout_at'])){
                    $result = $this->renderFailure(trans('messages.gym_visit_done_for_the_day'), Response::HTTP_OK);
                } 
                else{
                    UserGym::checkIn($userGym,$beacons['master_gym_id'],$beacons['master_beacon_id'],Auth::user()->user_id);
                    $allGymBeacons = MasterBeacon::getBeaconsByGym($beacons['master_gym_id']);
                    $result = $this->renderSuccess(trans('messages.check_in_successfully'),$allGymBeacons);
                }
            }
            else{
                $result = $this->renderFailure(trans('messages.check_in_failed'), Response::HTTP_OK);
            }   

        }
        catch(\Exception $e){
            UtilityHelper::logException(__METHOD__, $e);
            $result = $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
        return $result;
    }
     
    /**
        * 
        * Does check out of user in gym 
        * 
        * @param $data contains information of gym and its checkout beacons
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if successfully checkout and failure otherwise
        * 
    */
    public function postUserCheckOut($data){
        DB::beginTransaction();
        try{
            $beacon = MasterBeacon::getBeaconsById($data['masterBeaconId']);
            if(is_object($beacon)){
                $userGym = UserGym::getCheckInDetials($beacon['master_gym_id'],Auth::user()->user_id);
                if(empty($userGym)){
                    $result = $this->renderFailure(trans('messages.no_checkin_found'), Response::HTTP_OK);
                }
                else{
                    $checkinCheckoutDifference = CommonHelper::countTimeDIffrenceInMinutes($userGym['checkin_at']);
                    if($checkinCheckoutDifference < Constant::$MIN_TIME_FOR_GYM_VISIT){
                        return $this->renderFailure(trans('messages.min_time_must_for_gym_visit'), Response::HTTP_OK);
                    }
                    UserGym::checkOut($userGym,$data);
                    $now = new \DateTime('now');
                    $hourKey = $now->format('H'); 
                    $year = $now->format('Y');
                    $date = $now->format('Y-m-d');
                    $weekNumber = CommonHelper::getWeekNumber($date); 
                    UserHealthDevices::updateGymVisit($date,$hourKey,$weekNumber);
                    $points = Goal::updateGoals(Auth::user()->user_id,(int)Auth::user()->current_tier,Auth::user()->reward_point,$date,$weekNumber);
                    User::updateUserTierInfoAndPoint(Auth::user(),$weekNumber,$year,$points);
                    $result = $this->renderSuccess(trans('messages.check_out_successfully'),$userGym);
                    DB::commit();
                }
            }
            else{
               $result = $this->renderFailure(trans('messages.beacon_not_found'), Response::HTTP_OK);
            }
            
        }
        catch(\Exception $e){
            DB::rollback();
            UtilityHelper::logException(__METHOD__, $e);
            $result = $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
        return $result;
    }
    
    public function getUserGymDetails(){
        try{ 
                $userGym = UserGym::details(Auth::user());
                $result = $this->renderSuccess(trans('messages.gym_details_retrieved'),$userGym);
        }
        catch(\Exception $e){
            UtilityHelper::logException(__METHOD__, $e);
            $result = $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
        return $result;
    }
}
