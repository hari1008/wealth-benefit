<?php

/*
 * File: InviteContractImpl.php
 */

namespace App\Implementers;
use App\Contracts\InviteContract;
use App\Models\UserInvite;
use App\Models\AppInvite;
use App\Models\User;
use App\Codes\StatusCode;
use App\Implementers\BaseImplementer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Codes\Constant;
use App\Models\Device;
use App\Helper\Utility\UtilityHelper;
use App\Helper\Utility\CommonHelper;
use App\Models\NotificationsLogs;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Mail\SendInvite;


class InviteContractImpl extends BaseImplementer implements InviteContract {
    
    public function __construct() {
        
    }

    /**
        * 
        * Send bulk invitation to the registered user as well non registered used over their email's
        * 
        * @param $data contains information of user to whom user want to send invitation
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if invite sent successfully and failure otherwise
        * 
    */
    public function postSendInvitation($data){
        DB::beginTransaction();
        try{
            if($data['type'] == Constant::$IN_APP_USER_INVITE){
                $result = $this->sendInAppInvite(Auth::user()->user_id,$data['invitedUserId']);
            }
            else{
                $result =  $this->sendOutsideAppInvite(Auth::user()->user_id,$data['inviteeEmails']);
            }
            DB::commit();
            return $result;
        }
        catch(\Exception $e){
            DB::rollback();
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }
    
    public function sendInAppInvite($userId,$invitedUserId){
        $invite = UserInvite::getInvite($userId,$invitedUserId);
        if(is_object($invite)){
            $result = $this->renderFailure(trans('messages.invitation_already_sent'),Response::HTTP_CONFLICT,$invite);
        }
        else{
            $invite = UserInvite::insertInvites($userId,$invitedUserId);
            $basicMessage = ' sent you a friend request.';
            $notification = self::sendInviteNotification($invitedUserId,$basicMessage,Constant::$INVITE_NOTIFICATION,$invite['invite_id']);
            UserInvite::updateInviteFields($invite,['notification_id'=>$notification['notification_id']]);
            $result = $this->renderSuccess(trans('messages.invitation_sent_successfully'),$invite);
        }
        return $result;
    }
    
    public function sendOutsideAppInvite($userId,$inviteeEmails){
        $allUsersEmail = explode(',',CommonHelper::scriptStripper($inviteeEmails));
        $allReadyInvitedUsersEmail = AppInvite::getAlreadyInvitedEmails($allUsersEmail,$userId);
        $allUsersEmail = array_diff($allUsersEmail, $allReadyInvitedUsersEmail);
        $bulkInviteArray = self::preparingBulkForInvite($allUsersEmail,$userId);
        AppInvite::createInvites($bulkInviteArray);            

        if(!empty($allUsersEmail)){
            foreach($allUsersEmail as $email){
                
                        $message_to_send = Auth::user()->first_name.' '.Auth::user()->last_name.' sent you an invite.';
                        Mail::to($email)->queue(new SendInvite($message_to_send));
                }        
        }
        return $this->renderSuccess(trans('messages.invitation_sent_successfully'),$allUsersEmail);
    }
    
    /**
        * 
        * Provide list of all received invitations of the Users
        * 
        * @param Null
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with Invite objects if invite retrieved successfully and failure otherwise
        * 
    */
    public function getRecievedInvitation()
    {
        try{
            $allInvitations = UserInvite::listRecievedInvites(Auth::user()->user_id);
            if(is_object($allInvitations)){
                $result = $this->renderSuccess(trans('messages.received_invitation_list'),$allInvitations);
            } else {
                $result = $this->renderFailure(trans('messages.common_error'), StatusCode::$EXCEPTION,[false]);
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
        * Provide list of all sent invitations of the Users
        * 
        * @param Null
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with Invite objects if invite retrieved successfully and failure otherwise
        * 
    */
    public function getSentInvitation()
    {
        try{
            $allInvitations = UserInvite::listSentInvites(Auth::user()->user_id);
            if(is_object($allInvitations)){
                $result = $this->renderSuccess(trans('messages.sent_invitation_list'),$allInvitations);
            } else {
                $result = $this->renderFailure(trans('messages.common_error'), StatusCode::$EXCEPTION,[false]);
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
        * Provide list of all sent as well received invitations of the Users
        * 
        * @param Null
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with Invite objects if invite retrieved successfully and failure otherwise
        * 
    */
    public function getAllInvitation()
    {
        try{
            $allInvitations = UserInvite::listAllInvites(Auth::user()->user_id);
            if(is_object($allInvitations)){
                $result = $this->renderSuccess(trans('messages.received_invitation_list'),$allInvitations);
            } else {
                $result = $this->renderFailure(trans('messages.common_error'), StatusCode::$EXCEPTION,[false]);
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
        * Provide list of all sent as well received accepted invitations of the Users
        * 
        * @param Null
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with Invite objects if invite retrieved successfully and failure otherwise
        * 
    */
    public function getAllAcceptedInvitationUser($data)
    {
        try{
            $userId = Auth::user()->user_id;
            if(!empty($data['userid'])){
                $userId = $data['userid'];
            }
            $allInvitations = UserInvite::listAllAcceptedInvites($userId);
            if(is_object($allInvitations)){
                $result = $this->renderSuccess(trans('messages.received_accepted_invitation_list'),$allInvitations);
            } else {
                $result = $this->renderFailure(trans('messages.common_error'), StatusCode::$EXCEPTION,[false]);
            }
        }
        catch(\Exception $e){
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
            $result = $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
        return $result;
    }
    
    /**
        * 
        * Cancel the invitation by updating is_withdraw to 1
        * 
        * @param $data contains the information about the invitation that need to be withdraw
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with Invite objects if invite retrieved successfully and failure otherwise
        * 
    */
    public function putWithdrawInvitation($data)
    {
        try{
            $invite = UserInvite::checkUsersInvite($data['inviteId'], Auth::user()->user_id);
            
            if(is_object($invite)){
                $invite = UserInvite::withdrawInvite($data['inviteId']);
                $notification = NotificationsLogs::getNotificationById($invite['notification_id']);
                NotificationsLogs::updateInviteNotificstionStatus($notification, Constant::$INVITE_CANCELED);
                if(is_object($invite)){
                    $result = $this->renderSuccess(trans('messages.invite_withdraw_success'),[$invite]);
                }
                else{
                    $result = $this->renderFailure(trans('messages.common_error'), StatusCode::$EXCEPTION,[false]);
                }
            } else {
                $result = $this->renderFailure(trans('messages.not_authorised_to_update_invite'), StatusCode::$EXCEPTION,[false]);
            }
        }
        catch(\Exception $e){
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
            $result = $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
        return $result;
    }
    
    
    /**
        * 
        * Update Status of Invitation
        * 
        * @param $data contains the information about the invitation that need to be updated
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with Invite objects if invite updated successfully and failure otherwise
        *  
    */
    public function putUpdateInvitationStatus($data)
    {
        DB::beginTransaction();
        try{
            $invite = UserInvite::checkUsersInvite($data['inviteId'],Auth::user()->user_id);
            if(is_object($invite)) {
                
                $invite = UserInvite::updateInviteStatus($invite,$data['status']);
                $notification = NotificationsLogs::getNotificationById($invite['notification_id']);
                NotificationsLogs::updateInviteNotificstionStatus($notification, $data['status'],Constant::$userReadNotification);
                self::sendInviteNotification($invite['user_id'],self::inviteStatusMessage($data['status']), Constant::$ACCEPT_REJECT_INVITE_NOTIFICATION);
                $result = $this->renderSuccess(trans('messages.invite_status_updated'),$invite);
            } 
            else {
                $result = $this->renderFailure(trans('messages.not_authorised_to_update_invite'), StatusCode::$EXCEPTION,[]);
            }
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollback();
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
            $result = $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
        return $result;
    }
    
    public static function preparingBulkForInvite($allUsersEmail,$userId) {
        
        $bulkInviteArray = [];
        foreach($allUsersEmail as $email)
        {  
            $bulkInviteArray[] = [
                                    'user_id'=>$userId,
                                    'invitee_email_id'=>$email
                                ];
        }
        return $bulkInviteArray;
    }
    
    public static function sendInviteNotification($invitedUserId,$basicMessage,$notificationType,$inviteId = NULL) {
            
            $notificationData['reciever_user_id'] = $invitedUserId;
            $notificationData['sender_user_id'] = Auth::user()->user_id;
            $notificationData['type'] = $notificationType;
            $notificationData['invite_id'] = $inviteId;
            $notificationData['message'] = '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);">'. 
                                           '<span style="font-family:Akkurat;font-size:16px;letter-spacing:1pt;color:rgb(55,58,54);">'.
                                           Auth::user()->first_name.' '.Auth::user()->last_name.'</span>'.$basicMessage.'</div>';
            
            $notification = NotificationsLogs::createNotification($notificationData); // adding notification to the notification
            
            $deviceObj = new Device();
            $type = Constant::$INVITE_NOTIFICATION;
            $data = [
                    'type' => $type,
                    'alert' => Auth::user()->first_name.' '.Auth::user()->last_name.$basicMessage,
                    'toUserId'=>(array)$invitedUserId,
                    'time' => time()
                ];
            $deviceObj->sendPush($data); // sending push notifications to the user  
            
            return $notification;
    }
      
    /**
        * 
        * Provide list of all sent as well received accepted invitations of the Users
        * 
        * @param Null
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with Invite objects if invite retrieved successfully and failure otherwise
        * 
    */
    public function listUserToInvite($data)
    {
        try{
            $users = User::searchUser($data);
            if(is_object($users)){
                $result = $this->renderSuccess(trans('messages.invitation_user_list_retireved'),$users);
            } else {
                $result = $this->renderFailure(trans('messages.common_error'), StatusCode::$EXCEPTION,[false]);
            }
        }
        catch(\Exception $e){
            UtilityHelper::logException(__METHOD__, $e);
            $result = $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
        return $result;
    }
    
    public static function inviteStatusMessage($status){
        $message_to_send = '';
        if($status == Constant::$INVITE_ACCEPTED){
            $message_to_send = trans('messages.invitation_accepted');
        }
        elseif($status == Constant::$INVITE_REJECTED){
            $message_to_send = trans('messages.invitation_rejected');
        }
        return ' '.$message_to_send;
    }
    
}
