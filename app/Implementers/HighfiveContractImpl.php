<?php

/*
 * File: HighfiveContractImpl.php
 */

namespace App\Implementers;
use App\Contracts\HighfiveContract;
use App\Implementers\BaseImplementer;
use App\Codes\Constant;
use App\Models\Highfive;
use App\Models\Device;
use App\Helper\Utility\UtilityHelper;
use Symfony\Component\HttpFoundation\Response;
use App\Models\NotificationsLogs;
use Illuminate\Support\Facades\Auth;


class HighfiveContractImpl extends BaseImplementer implements HighfiveContract {
    
    public function __construct() {
        
    }
    
    /**
        * 
        * Does insert a record when user send high five to another user
        * 
        * @param $data contains information of user to whom user want to send high five
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with high five object if successfully entered the data and failure otherwise
        * 
    */
    public function postSendHighfiveUser($data){
        try{
            $highfive = Highfive::insertHighfive($data);
            if(!empty($highfive['for_user_id'])){
                $deviceObj = new Device();
                $type = Constant::$HIGHFIVE_NOTIFICATION;
                $data = array(
                    'type' => $type,
                    'alert' => trans('messages.highfive_recieved').Auth::user()->first_name.' '.Auth::user()->last_name,
                    'toUserId'=>(array)$highfive['for_user_id'],
                    'time' => time());
                $deviceObj->sendPush($data);
                $notificationData['reciever_user_id'] = $highfive['for_user_id'];
                $notificationData['sender_user_id'] = $highfive['user_id'];
                $notificationData['type'] = $type;
                $notificationData['message'] = '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);">'.
                                                trans('messages.highfive_recieved').Auth::user()->first_name.' '.Auth::user()->last_name.'</div>';
                $notification = NotificationsLogs::createNotification($notificationData); // adding notification to the notification
            }
            $result = $this->renderSuccess(trans('messages.highfive_sent_successfully'),[$highfive]);
        }
        catch(\Exception $e){
            UtilityHelper::logException(__METHOD__, $e);
            $result = $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
        return $result;
    }
     
    /**
        * 
        * Does provide the list of all received high five of the user
        * 
        * @param NULL
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with high five objects if successfully retrieved 
        * 
    */
    public function getReceivedHighfive(){
        try{
            $allHighFive = Highfive::getAllHighfive();
            $result = $this->renderSuccess(trans('messages.highfive_retrieved_successfully'),$allHighFive);
        }
        catch(\Exception $e){
            UtilityHelper::logException(__METHOD__, $e);
            $result = $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
        return $result;
    }
}
