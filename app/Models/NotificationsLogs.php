<?php

/*
 * File: NotificationsLogs.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Codes\Constant;
use App\Helper\Utility\CommonHelper;
class NotificationsLogs extends Model
{
    use SoftDeletes; 
    protected $table = 'notifications_logs';
    protected $primaryKey = 'notification_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'notification_id', 'source_user_id', 'destination_user_id','type','message','payload'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'updated_at', 'deleted_at'
    ];
    
    
    protected $casts = [
        'notification_id' => 'integer',
        'sender_user_id' => 'integer',
        'reciever_user_id' => 'integer',
        'type' => 'integer',
        'status' => 'integer',
        'message' => 'string',
        'payload' => 'string'
    ]; 
    
    /**
    * Get the user that owns the phone.
    */
    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'sender_user_id', 'user_id');
    }
    
    /**
    * Get the user that owns the phone.
    */
    public function reciever()
    {
        return $this->belongsTo('App\Models\User', 'reciever_user_id', 'user_id');
    }
    /**
        * 
        * Creating New Help Row 
        * 
        * @param $data contains description about help required
        * 
        * @return help object on success , false otherwise
        * 
    */
    public static function createNotification($data){
        $notify = new NotificationsLogs();
        $notify->sender_user_id = $data['sender_user_id'];
        $notify->reciever_user_id = $data['reciever_user_id'];
        $notify->type = $data['type'];
        $notify->message = CommonHelper::scriptStripper($data['message']);
        if(!empty($data['invite_id'])){
            $notify->invite_id = $data['invite_id'];
        }
        $notify->save();
        return $notify;
    }
    public static function listNotifications(){
        $result = NotificationsLogs::where('reciever_user_id',Auth::user()->user_id)
                    ->with(array('sender'=>function($query){
                        $query->select('user_id','image');
                    }))
                    ->orderBy('created_at', 'desc')
                    ->paginate(Constant::$NOTIFICATION_LISTING_PAGINATE);
        return $result;  
    }
    public static function getNotification($notificationId){
        $result = NotificationsLogs::where('notification_id',$notificationId)
                    ->with(array('reciever'=>function($query){
                        $query->select('user_id','email');
                    }))
                    ->first();
        return $result;  
    }
    
    public static function getNotificationById($notificationId){
        $result = NotificationsLogs::where('notification_id',$notificationId)->first();
        return $result;  
    }
    
    public static function makeNotificationRead($notification){
        $notification->status = Constant::$userReadNotification;
        $notification->save(); 
        return $notification;  
    }
    
    public static function updateInviteNotificstionStatus($notification,$status,$readStatus = NULL){
        $notification->invite_notification_status = $status;
        if(!empty($readStatus)){
         $notification->status = $readStatus;   
        }
        $notification->save(); 
    }
    
    public static function getAllUnreadNotification($recieverUserId){
        $result = NotificationsLogs::where('reciever_user_id',$recieverUserId)->where('status',0)->count();
        return $result;  
    }
}
