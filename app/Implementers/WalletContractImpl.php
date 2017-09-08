<?php

/*
 * File: WalletContractImpl.php
 */

namespace App\Implementers;
use App\Contracts\WalletContract;
use App\Implementers\BaseImplementer;
use App\Helper\Utility\UtilityHelper;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserWallet;
use Illuminate\Support\Facades\Auth;
use App\Codes\Constant;


class WalletContractImpl extends BaseImplementer implements WalletContract {
    
    public function __construct() {
        
    }
    
    /**
     * 
     * Provide list of works
     * 
     * @param null
     * 
     * @throws Exception If something happens during the process
     * 
     * @return success if everything went right
     * 
     */
    public function getWalletRewardList() {
        try {
            $rewards = UserWallet::getRewards(Auth::user()->user_id);
            return $this->renderSuccess(trans('messages.reward_retrieved_successfully'), $rewards);
        } catch (\Exception $e) {
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }
    
    /**
     * 
     * Insert a issue when someone reported it
     * 
     * @param $data which contains information about issue faced by the user
     * 
     * @throws Exception If something happens during the process
     * 
     * @return reported issue object with success if inserted successfully otherwise failure 
     * 
     */
    public function postAddRewardInWallet($data) {
        try {
            $reward = UserWallet::findRewardInWallet($data);
            if(is_object($reward)){
                $result = $this->renderFailure(trans('messages.allready_added_to_wallet'), Response::HTTP_OK,$reward);
            }
            else{
                $user = Auth::user();
                $totalWeeklyGoals = $user->allWeeklyGoals()->first();
                $totalRedeemedRewards = $user->allRedeemedRewards()->first();
                $totalWalletRewards = $user->allWalletRewards()->first();
                $redeemAvailability = $totalWeeklyGoals['weekly_goals'] - ($totalRedeemedRewards['redeemed_rewards'] + $totalWalletRewards['wallet_rewards']);
                if($redeemAvailability < Constant::$ONE){
                    return $this->renderFailure(trans('messages.insufficient_weekly_goals_to_add_wallet'), Response::HTTP_OK);
                }
                $reward = UserWallet::addRewardToWallet($data);
                $result = $this->renderSuccess(trans('messages.added_to_wallet'),$reward);
            }
        } catch (\Exception $e) {
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
            $result = $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
        return $result;
    }
}
