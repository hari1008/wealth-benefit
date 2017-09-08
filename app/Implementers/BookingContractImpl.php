<?php

/*
 * File: BookingContractImpl.php
 */

namespace App\Implementers;
use App\Contracts\BookingContract;
use App\Implementers\BaseImplementer;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserBooking;
use App\Helper\Utility\UtilityHelper;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSession;
use App\Codes\Constant;
use Illuminate\Support\Facades\DB;
use App\Models\Device;
use App\Models\NotificationsLogs;
use App\Models\UserHealthDevices;
use App\Models\UserFeedback;


class BookingContractImpl extends BaseImplementer implements BookingContract {
    
    public function __construct() {
        
    }
    
    /**
        * 
        * Does booking of calendar for expert
        * 
        * @param $data which contains information about sessions that need to be booked
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if successfully booked session otherwise failure 
        * 
    */
    public function postBookCalendar($data){
            DB::beginTransaction();
            try {
                $result = UserBooking::checkBookCalender($data);
                if(count($result)){
                    return $this->renderFailure(trans('messages.expert_session_already_booked'),Response::HTTP_CONFLICT,$result);
                }
                else{
                    $userExpertSessionInfo = UserSession::getUserExpertSessionInfo(Auth::user()->user_id, $data['bookings'][0]['expertId']);
                    if($userExpertSessionInfo['sessions_available'] >= count($data['bookings'])){
                        UserBooking::postBookCalender($data); 
                        UserSession::updateSessionCount($userExpertSessionInfo,Constant::$REDUCE_SESSIONS,count($data['bookings']));
                        $first_name = (!empty(Auth::user()->first_name))?Auth::user()->first_name:"Unknown";
                        $last_name = (!empty(Auth::user()->last_name))?Auth::user()->last_name:"";
                        $pushMessage =  $first_name.' '.$last_name.trans('messages.booked_sessions');  
                        $notificationMessage = '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);">'. 
                                           '<span style="font-family:Akkurat;font-size:16px;letter-spacing:1pt;color:rgb(55,58,54);">'.
                                           $first_name.' '.$last_name.'</span>'.trans('messages.booked_sessions').'</div>';
                        static::sendNotification($pushMessage,$notificationMessage,Constant::$BOOK_EXPERT_NOTIFICATION,Auth::user()->user_id,$data['bookings'][0]['expertId']);
                        DB::commit();
                        return $this->renderSuccess(trans('messages.expert_session_booked_successfully'), []);
                    }
                    else{
                        return $this->renderSuccess(trans('messages.not_enough_sessions_in_account'), []);
                    }   
                }    
            } catch (\Exception $e) {
                DB::rollBack();
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
            }
    }
    
    /**
        * 
        * Bring information booking sessions of expert
        * 
        * @param NULL
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if successfully retrieved booked sessions 
        * 
    */
    public function getBookingList($data){
            try {
                $userBooking = UserBooking::getBookingList($data); 
                return $this->renderSuccess(trans('messages.booked_session_retreived_successfully'), $userBooking);
                  
            } catch (\Exception $e) {
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
            }
    }
    
    /**
        * 
        * Does booking canceling of expert
        * 
        * @param $data which contains information of booking which needs to be cancel
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if booked session canceled successfully otherwise failure 
        * 
    */
    public function putCancelBooking($data){
            DB::beginTransaction();
            try {
                $userBooking = UserBooking::where('booking_id',$data['bookingId'])->where('expert_id',Auth::user()->user_id)->first();
                if(is_object($userBooking)){
                    if($userBooking['booking_status'] == Constant::$BOOKING_CANCELED_STATUS){
                        return $this->renderFailure(trans('messages.booked_session_already_canceled'), Response::HTTP_OK);
                    }
                    $userBooking = UserBooking::putCancelBooking($userBooking);
                    $userExpertSessionInfo = UserSession::getUserExpertSessionInfo($userBooking['user_id'],$userBooking['expert_id']);
                    UserSession::updateSessionCount($userExpertSessionInfo,Constant::$ADD_SESSIONS);
                    $first_name = (!empty(Auth::user()->first_name))?Auth::user()->first_name:"Unknown";
                    $last_name = (!empty(Auth::user()->last_name))?Auth::user()->last_name:"";
                    $pushMessage =  $first_name.' '.$last_name.trans('messages.canceled_sessions',['booking_date'=>$userBooking['date']]);  
                    $notificationMessage = '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);">'. 
                                       '<span style="font-family:Akkurat;font-size:16px;letter-spacing:1pt;color:rgb(55,58,54);">'.
                                       $first_name.' '.$last_name.'</span>'.trans('messages.canceled_sessions',['booking_date'=>$userBooking['date']]).'</div>';
                    static::sendNotification($pushMessage,$notificationMessage,Constant::$CANCEL_BOOKING_NOTIFICATION,$userBooking['expert_id'],$userBooking['user_id']);
                    DB::commit();
                    return $this->renderSuccess(trans('messages.booked_session_canceled_successfully'),$userBooking);
                }
                else{
                    return $this->renderFailure(trans('messages.booked_session_not_found'), Response::HTTP_OK);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
            }
    }
    
    /**
        * 
        * Does move booking of expert
        * 
        * @param $data which contains information of booking which needs to be move
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if booked session canceled successfully otherwise failure 
        * 
    */
    public function putMoveBooking($data){
            DB::beginTransaction();
            try {
                $userBooking = UserBooking::where('booking_id',$data['bookingId'])->where('expert_id',Auth::user()->user_id)->first();
                if(is_object($userBooking)){
                    $userBooking = UserBooking::putMoveBooking($userBooking,$data);
                    $first_name = (!empty(Auth::user()->first_name))?Auth::user()->first_name:"Unknown";
                    $last_name = (!empty(Auth::user()->last_name))?Auth::user()->last_name:"";
                    $pushMessage =  $first_name.' '.$last_name.trans('messages.moved_session');  
                    $notificationMessage = '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);">'. 
                                       '<span style="font-family:Akkurat;font-size:16px;letter-spacing:1pt;color:rgb(55,58,54);">'.
                                       $first_name.' '.$last_name.'</span>'.trans('messages.moved_session').'</div>';
                    static::sendNotification($pushMessage,$notificationMessage,Constant::$MOVE_BOOKING_NOTIFICATION,$userBooking['expert_id'],$userBooking['user_id']);
                    DB::commit();
                    return $this->renderSuccess(trans('messages.booked_session_moved_successfully'),$userBooking);
                }
                else{
                    return $this->renderFailure(trans('messages.booked_session_not_found'), Response::HTTP_OK);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
            }
    }
    
    public static function sendNotification($pushMessage,$notificationMessage,$type,$sender,$reciever){
            $deviceObj = new Device();
            $data = array(
                'type' => $type,
                'alert' => $pushMessage,
                'toUserId' => (array)$reciever,
                'time' => time());
            $deviceObj->sendPush($data);
            
            $notificationData['reciever_user_id'] = $reciever;
            $notificationData['sender_user_id'] = $sender;
            $notificationData['type'] = $type;
            $notificationData['message'] = $notificationMessage;
            $notification = NotificationsLogs::createNotification($notificationData); // adding notification to the notification
            
    }
    
    public function postExpertBookingFeedBack($data){
            DB::beginTransaction();
            try {
                    $userBooking = UserBooking::where('booking_id',$data['bookingId'])->first();
                    $feedback = UserFeedback::getFeedback($data,Auth::user()->user_id,$userBooking['expert_id']) ;  
                    if(is_object($feedback)){
                        return $this->renderFailure(trans('messages.feedback_already_submitted'), Response::HTTP_OK);
                    }   
                    else{
                        $feedback = UserFeedback::insertFeedback($data,Auth::user()->user_id,$userBooking['expert_id']);
                        UserBooking::updateFeedbackStatus($userBooking);
                        DB::commit();
                        return $this->renderSuccess(trans('messages.feedback_captured_successfully'),$feedback);
                    }
            } catch (\Exception $e) {
                DB::rollBack();
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
            }
    }
    
}
