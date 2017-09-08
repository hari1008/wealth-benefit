<?php

/*
 * File: ConversationContractImpl.php
 */

namespace App\Implementers;
use App\Contracts\ConversationContract;
use App\Implementers\BaseImplementer;
use App\Helper\Utility\UtilityHelper;
use Symfony\Component\HttpFoundation\Response;
use App\Codes\Constant;
use Illuminate\Support\Facades\Auth;
use App\Models\UserInvite;
use App\Models\UserConversation;
use App\Models\Device;

class ConversationContractImpl extends BaseImplementer implements ConversationContract {
    
    public function __construct() {
    }
    
    /**
        * 
        * Provide list of messages of the behalf of user and timestamp
        * 
        * @param $request contains type of data required (1 - next , 2 - Previous) 
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with messages objects if retrieved device data successfully
        * 
    */
    public function getConversations($data) {
        try{ 
            $conversations = UserConversation::userMessageList($data,Auth::user()->user_id);
            return $this->renderSuccess(trans('messages.message_list_get_successfully'),$conversations);
        } 
        catch(\Exception $e){
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    
    /**
        * 
        * Send Message in database
        * 
        * @param $request contains message and receiver id
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with message objects if data inserted successfully
        * 
    */
    public function postSendMessage($data) {
        try{ 
            $result = UserInvite::checkIsUserBlockedOrNot(Auth::user()->user_id,$data['receiverId']);
            if(is_object($result)){
                return $this->renderFailure(trans('messages.user_blocked'), Response::HTTP_OK);
            }
            else{
                $message = UserConversation::insertUserMessage($data,Auth::user()->user_id);
                $pushMessage = trans('messages.new_chat_message');
                $this->sendPushNotification($pushMessage, Constant::$NEW_MESSAGE_NOTIFICATION,$data['receiverId'],Auth::user()->user_id,Auth::user()->first_name,Auth::user()->last_name,Auth::user()->image);
                return $this->renderSuccess(trans('messages.message_sent_successfully'),$message);
                
            }
        } 
        catch(\Exception $e){
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    
    public static function sendPushNotification($pushMessage,$type,$reciever,$sender,$firstname,$lastname,$image){
            $deviceObj = new Device();
            $data = array(
                'senderId'=>$sender,
                'senderFirstname'=>$firstname,
                'senderLastname'=>$lastname,
                'senderImage'=>$image,
                'type' => $type,
                'alert' => $pushMessage,
                'toUserId' => (array)$reciever,
                'time' => time());
            $deviceObj->sendPush($data);
    }
    
}    