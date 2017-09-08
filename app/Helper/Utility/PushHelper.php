<?php
namespace App\Helpers\Utility;
use App\Modules\Game\Model\Game;
use App\Modules\User\Model\User;

/*
 * This is Utility Class of the Image
 */

class PushHelper {
    
 protected $sounds = array(
        '10'=>'default');
protected $tokens =[];


    public static  function send_ios_push($data,$device_tokens,$message){
        $payload_body= PushHelper::getPayLoad($data,$message);
      
         // path to certificate file
       
      $certFile = base_path()."/".env('APNS_CERTIFICATE');
      
//       if(file_exists($certFile))
//           echo ' file found.';
//       else
//            echo ' file not found.';
//        
//die();
// passphrase
        $passPhrase = base_path()."/".env('APNS_CERTIFICATE_PWD');
        $streamContext = stream_context_create();
        stream_context_set_option($streamContext,'ssl', 'local_cert', $certFile);
        stream_context_set_option($streamContext, 'ssl', 'passphrase', $passPhrase);

            // Open a connection to the APNS server
        
        
       $fp =stream_socket_client(env('SSL_URL'),$error,$errorString,60,STREAM_CLIENT_CONNECT, $streamContext);


        if (!$fp)
        {
           return false;
        }

        $body['aps'] = $payload_body;
      
        // Encode the payload as JSON
         $payload = json_encode($body,JSON_UNESCAPED_UNICODE);
    
        foreach($device_tokens as $user_id => $deviceToken){
            
            
            $payload = json_encode($body);
            
            foreach($deviceToken as $token){

             $msg = chr(0) . pack('n', 32) . pack('H*',$token) . pack('n', strlen($payload)) . $payload;
////            // Send it to the server
             $result = fwrite($fp, $msg, strlen($msg));
            }
         
        }
      
       fclose($fp);
        return true;
    }
    public static function getPayLoad($data,$message){
        
        
        switch($data['notification_type']){
            case '1': 
                $event = $data['event_id'];
                $game = Game::find($event);
                $user = User::find($data['sender_id']);
                $payload=array(
                            'sound'=>'10',
                            'alert'=>$message,
                            'event_id'=>$data['event_id'],
                            'push_tag'=>1,
                            'userId'=> $user->id,
                            'timeStamp'=>$game->invite_expires_time,
                             'content-available'=>1
                );
                break;
            case '2' :
                $payload=array(
                            'sound'=>'10',
                            'alert'=>$message,
                            'event_id'=>$data['event_id'],
                            'push_tag'=>2,
                           
                );
                break;
            case '3':
                 $payload=array(
                            'sound'=>'10',
                            'alert'=>$message,
                            'event_id'=>$data['event_id'],
                            'push_tag'=>3,
                           
                );
                break;
            case '4':
                $payload=array(
                            'sound'=>'10',
                            'alert'=>$message,
                            'event_id'=>$data['event_id'],
                            'push_tag'=>4,
                           
                );
                break;
        }
        
        return $payload;
    }
       
}   // clear badge method