<?php

/*
 * File: Device.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Codes\Constant;
use App\Models\NotificationsLogs;

class Device extends Model  {
    
    use SoftDeletes;  
    protected $table        = 'devices';
    protected $primaryKey   = 'device_id';
    protected $fillable     = ['device_id','user_id','device_token','device_type','user_token'];
    protected $dates = ['deleted_at'];

    public static function unRegisterSingle($userId){
         $time = date('Y-m-d H:i:s');
       Device::where('user_id',$userId)->update(['deleted_at'=>$time]);
       return true;
    }
    public static function unRegister_all($userId){
        $time = date('Y-m-d H:i:s');
       Device::where('user_id',$userId)->update(['deleted_at'=>$time]);
       return true;
    }
    
    /**
        * 
        * Registering device by updating their user token 
        * 
        * @param $user_id contains Primary key of the User , $device_token contains device id ,  $device_type contains device type info
        * 
        * @return Created User Token
        * 
    */
    public function registerDevice($userId, $deviceToken, $deviceType) {
      
        $time=time();
        $str = 'abcdefghijklmnopqrstuvwxyz0123456789'."$time";
        $shuffled = str_shuffle($str);
        $userToken = md5($shuffled);
        $data = array('user_id' => $userId, 'device_token' => $deviceToken, 'device_type' => $deviceType,'user_token'=>$userToken);
           
        // insert an entry to device table for user authentication
        if(!empty($deviceToken)){
            Device::where('device_token',$deviceToken)->update(['device_token'=>'']);
        }
        $device = Device::firstOrNew(array('user_id' => $userId));
        $device->fill($data);
        $device->save();
        
        return $userToken;
    }
    
    public function getDeviceTokens($userIds) {
        $deviceTokens=array();
       
        $token=Device::whereIN('user_id',$userIds)->where('deleted_at',NULL)->whereRaw('device_token IS NOT NULL AND device_token!=""')->select('device_token','device_type','user_id')->get();
    
        foreach($token as $t){
            
            $deviceTokens[$t->user_id][]=array('device_token'=>$t->device_token,'device_type'=>$t->device_type);
        }
    
        return $deviceTokens;
    }
    
    public static function  getUserByDevice($request) {
        $device = Device::where('user_token',$request->header('userToken'))->where('deleted_at',Constant::$DELETED_NULL);
        return $device;
    } 
    
    

    public function getPayLoad($data) {  
        $payload = [];
        switch ($data['type']) {
            case '0':   // For Send Invite Notification
                $alert = $data['alert'];
                $payload = array(
                    'userId' => (int)$data['toUserId'],
                    'alert' => $alert,
                    'time' => $data['time'],
                    'type' => $data['type']
                );
                break;
            case '1':
            case '2':
            case '3':
            case '4':
            case '5':
            case '6':
            case '7':
            case '8':
            case '9': 
            case '10':      
                $alert = $data['alert'];
                $payload = array(
                    'sound' => $this->sounds[10],
                    'alert' => $alert,
                    'time' => $data['time'],
                    'type' => $data['type']
                );
                break;
            case '11':      
                $alert = $data['alert'];
                $payload = array(
                    'sound' => $this->sounds[10],
                    'alert' => $alert,
                    'time' => $data['time'],
                    'sessionEndtime' => $data['sessionEndtime'],
                    'type' => $data['type']
                );
                break;
            case '12':      
                $alert = $data['alert'];
                $payload = array(
                    'sound' => $this->sounds[10],
                    'alert' => $alert,
                    'time' => $data['time'],
                    'senderId' => $data['senderId'],
                    'senderFirstname' => $data['senderFirstname'],
                    'senderLastname' => $data['senderLastname'],
                    'senderImage' => $data['senderImage'],
                    'type' => $data['type']
                );
                break;
            }
            
        return $payload;
    }

    public function sendPush($data = array()) {
        
        $d = $this->getDeviceTokens($data['toUserId']);
        
        $deviceTokens = array();
        $registrationIds = array();

        foreach ($d as $userId => $u) {
            foreach ($u as $device) {
                if ($device['device_type'] == 'ios') {
                    $deviceTokens[$userId][] = $device['device_token'];
                } else {
                    $registrationIds[] = $device['device_token'];
                }
            }
        }
        
        if ($deviceTokens) {
            $this->sendIosPush($data, $deviceTokens);
            
        }
       
        
        if ($registrationIds) {
             
            $this->gcmPush($data, $registrationIds);
        }
    }

    public function sendIosPush($data, $device_tokens) {
        
        $payload_body = $this->getPayLoad($data);
       
        
        // path to certificate file

        $ctx = stream_context_create();

        stream_context_set_option($ctx, 'ssl', 'local_cert', public_path().'/'.env('PEM_FILE'));
        stream_context_set_option($ctx, 'ssl', 'passphrase', '');

       // echo env('PUSH_URL');die; public_path().'/'.env('PEM_FILE'); die;
        // Open a connection to the APNS server
        $fp = stream_socket_client(
                env('PUSH_URL'), $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        
        /*$fp = stream_socket_client(
                'ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);*/
        if (!$fp) {
            return false;
        }

        $body['aps'] = $payload_body;

        // Encode the payload as JSON
        $payload = json_encode($body);

        foreach ($device_tokens as $user_id => $deviceToken) {

            $badge_count = $this->getBadgeCount($user_id);
            $badge = $badge_count;
            $body['aps']['badge'] = $badge+1;
            $payload = json_encode($body);

            // Build the binary notification
            //dd($deviceToken);
            foreach ($deviceToken as $token) {
                $msg = chr(0) . pack('n', 32) . pack('H*', $token) . pack('n', strlen($payload)) . $payload;
                // Send it to the server
                $result = fwrite($fp, $msg, strlen($msg));
            }
        }
        fclose($fp);
        //return true;
    }

    public function gcmPush($data, $registrationIds) {
        
        
        $payload_body = $this->getPayLoad($data);
        
        
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => $registrationIds,
            'data' => $payload_body,
//            'notification'=>['body'=>$payload_body,'title'=>'Benefit Wellness'],
            'notification'=>$payload_body,
        );
        //print_r($fields);
        $headers = array(
            'Authorization: key=AAAAHOby7Zc:APA91bE5F6r7Na1UuUEdXW0F-G4YgBmHcGTybawxKJKGVmWKp_jGbC5pS0eQirgOlNG-Vxr6czCFipGi7VxUqV-9onsWpFJbzLhsoQJy82pWWvLe-HptPewlEbDrB9ta3ZEUfYS97yOqbKA1-Pid8vQpm5QoEGBYyA',
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        
        // Close connection
        
        curl_close($ch);
        if (!$result) {
            return 0;
        } else {
            return 1;
        }
    }
    
    public function getBadgeCount($user_id) {
        $unreadCount = NotificationsLogs::where('status',  Constant::$userUnreadNotification)->where('reciever_user_id',$user_id)->count();
        return $unreadCount;
    }
}

