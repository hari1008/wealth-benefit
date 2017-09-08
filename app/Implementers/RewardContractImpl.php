<?php

/*
 * File: WorkContractImpl.php
 */

namespace App\Implementers;
use App\Contracts\RewardContract;
use App\Models\MasterReward;
use App\Implementers\BaseImplementer;
use App\Helper\Utility\UtilityHelper;
use Symfony\Component\HttpFoundation\Response;
use App\Models\EcosystemReward;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Codes\Constant;
use App\Models\Device;
use App\Models\UserPointHistory;
use Illuminate\Support\Facades\DB;
use App\Models\UserWallet;

class RewardContractImpl extends BaseImplementer implements RewardContract {
    
    public function __construct() {
    }
    
    /**
        * 
        * Provide list of works of the behalf of type
        * 
        * @param $data contains type of work
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with works objects if retrieved device data successfully
        * 
    */
    public function getRewards() {
        try{ 
            $rewards = EcosystemReward::getRewards(Auth::user()->ecosystem_id);
            return $this->renderSuccess(trans('messages.reward_retrieved_successfully'),$rewards);
        } 
        catch(\Exception $e){
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    public static function sendPushNotification($pushMessage,$type,$reciever){
            $deviceObj = new Device();
            $data = array(
                'type' => $type,
                'alert' => $pushMessage,
                'toUserId' => (array)$reciever,
                'time' => time());
            $deviceObj->sendPush($data);
    }
    
    
    public function postRewardRedeem($data) {
        DB::beginTransaction();
        try{ 
            $user = Auth::user();
            if($data['isWalletReward'] == Constant::$NO){
                $totalWeeklyGoals = $user->allWeeklyGoals()->first();
                $totalRedeemedRewards = $user->allRedeemedRewards()->first();
                $totalWalletRewards = $user->allWalletRewards()->first();
                $redeemAvailability = $totalWeeklyGoals['weekly_goals'] - ($totalRedeemedRewards['redeemed_rewards'] + $totalWalletRewards['wallet_rewards']);
                if($redeemAvailability < Constant::$ONE){
                    return $this->renderFailure(trans('messages.insufficient_weekly_goals'), Response::HTTP_OK);
                }
            }
            $reward = MasterReward::with('merchant')->where('master_reward_id',$data['masterRewardId'])->withTrashed()->first();
            if($reward['merchant']['merchant_code'] != $data['merchantCode']){
                return $this->renderFailure(trans('messages.wrong_merchant_code'), Response::HTTP_OK);
            }
            $rewards = MasterReward::redeemReward($reward,$user['user_id']);
            UserWallet::removeReward($data['masterRewardId'],$user['user_id']);
            DB::commit();
            return $this->renderSuccess(trans('messages.reward_redeemed_successfully'),$rewards);
        } 
        catch(\Exception $e){
            DB::rollback();
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    
    public function postUsePoints($data) {
        DB::beginTransaction();
        try{ 
            $user = Auth::user();
            if($user['reward_point'] < $data['points']){
                return $this->renderFailure(trans('messages.points_not_available'), Response::HTTP_OK);
            }
            $points = $user['reward_point'] - $data['points'];
            UserPointHistory::insertPointHistory($data['points'],$user['user_id'], Constant::$DEBIT);
            User::updateUserTierInfoAndPoint($user,$user['tier_start_week'],$user['tier_start_year'],$points);
            DB::commit();
            return $this->renderSuccess(trans('messages.points_used_successfully'),$points);
        } 
        catch(\Exception $e){
            DB::rollback();
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
}    