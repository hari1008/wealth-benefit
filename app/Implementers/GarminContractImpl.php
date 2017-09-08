<?php

/*
 * File: WorkContractImpl.php
 */

namespace App\Implementers;
use App\Contracts\GarminContract;
use App\Implementers\BaseImplementer;
use App\Helper\Utility\UtilityHelper;
use Symfony\Component\HttpFoundation\Response;
use App\Codes\Constant;
use App\Models\UserGarminInfo;
use Illuminate\Support\Facades\Auth;
use App\Models\UserGarminData;


class GarminContractImpl extends BaseImplementer implements GarminContract {
    
    public function __construct() {
    }
    
    /**
        * 
        * Provide the request token
        * 
        * @param $data contains type of work
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with works objects if retrieved device data successfully
        * 
    */
    public function getRequestToken() {
        try{
            $request_method = 'POST';
            $data = [
               'host' => 'connectapitest.garmin.com/',
               'call_path' => 'oauth-service-1.0/oauth/request_token',
               'consumer_key' => '895538fa-979e-436f-b5c9-bfdb98e714be',
               'consumer_secret' => 'ZALPNP0PuwfnfSgYKoeDtxgyJHRxH0mngwx'
            ];

            $oauthData = $this->build_oauth_data($request_method, $data , Constant::$GARMIN_SIGNATURE_TYPE['RequestToken']);

            $header = array();
            $header[] = 'Content-length: 0';
            $header[] = 'Content-type: application/json';
            $header[] = 'Authorization: OAuth oauth_consumer_key="'.$oauthData['oauth_consumer_key'].'",'
                    . 'oauth_signature_method="'.$oauthData['oauth_signature_method'].'",'
                    . 'oauth_timestamp="'.$oauthData['oauth_timestamp'].'",'
                    . 'oauth_nonce="'.$oauthData['oauth_nonce'].'",'
                    . 'oauth_version="'.$oauthData['oauth_version'].'",'
                    . 'oauth_signature="'.$oauthData['oauth_signature'].'"';
            $url = 'http://'.$data['host'].$data['call_path'];
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
            curl_setopt($ch, CURLOPT_POST,TRUE); 
            $result = curl_exec($ch); 
            
            if (strpos($result, 'oauth_token') !== false) {
                return $this->renderSuccess(trans('messages.request_token_get_successfully'),$result);
            }     
            else{
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
            }
            
        } 
        catch(\Exception $e){
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    
    /**
        * 
        * Provide the access token
        * 
        * @param $request contains oauthToken,tokenSecret,oauthVerifier
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with token if retrieved device data successfully
        * 
    */
    public function getAccessToken($request) {
        try{
            $request_method = 'POST';
            $data = [
               'host' => 'connectapitest.garmin.com/',
               'call_path' => 'oauth-service-1.0/oauth/access_token',
               'consumer_key' => '895538fa-979e-436f-b5c9-bfdb98e714be',
               'consumer_secret' => 'ZALPNP0PuwfnfSgYKoeDtxgyJHRxH0mngwx',
               'oauth_token' => $request['oauthToken'], 
               'oauth_verifier' => $request['oauthVerifier'],
               'token_secret' => $request['tokenSecret']  
            ];

            $oauthData = $this->build_oauth_data($request_method, $data , Constant::$GARMIN_SIGNATURE_TYPE['AccessToken']);
            

            $header = array();
            $header[] = 'Content-length: 0';
            $header[] = 'Content-type: application/json';
            $header[] = 'Authorization: OAuth oauth_consumer_key="'.$oauthData['oauth_consumer_key'].'",'
                    . 'oauth_signature_method="'.$oauthData['oauth_signature_method'].'",'
                    . 'oauth_timestamp="'.$oauthData['oauth_timestamp'].'",'
                    . 'oauth_nonce="'.$oauthData['oauth_nonce'].'",'
                    . 'oauth_token="'.$request['oauthToken'].'",'
                    . 'oauth_verifier="'.$request['oauthVerifier'].'",'
                    . 'oauth_version="'.$oauthData['oauth_version'].'",'
                    . 'oauth_signature="'.$oauthData['oauth_signature'].'"';
            $url = 'http://'.$data['host'].$data['call_path'];
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
            curl_setopt($ch, CURLOPT_POST,TRUE); 
            $result = curl_exec($ch); 
            if (strpos($result, 'oauth_token') !== false) {
                return $this->renderSuccess(trans('messages.access_token_get_successfully'),$result);
            }     
            else{
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
            }
            
        } 
        catch(\Exception $e){
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    
    
    /**
        * 
        * Provide daily data
        * 
        * @param $request contains oauthToken,tokenSecret,uploadStartTimeInSeconds,uploadEndTimeInSeconds
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if retrieved data successfully
        * 
    */
    public function getDailiesData($request) {
        try{
            $request_method = 'GET';
            $data = [
               'host' => 'gcsapitest.garmin.com/',
               'call_path' => 'wellness-api/rest/dailies',
               'consumer_key' => '895538fa-979e-436f-b5c9-bfdb98e714be',
               'consumer_secret' => 'ZALPNP0PuwfnfSgYKoeDtxgyJHRxH0mngwx',
               'oauth_token' => $request['oauthToken'],
               'token_secret' => $request['tokenSecret'] ,
               'uploadStartTimeInSeconds' => $request['uploadStartTimeInSeconds'] ,
               'uploadEndTimeInSeconds' => $request['uploadEndTimeInSeconds'] , 
            ];

            $oauthData = $this->build_oauth_data($request_method, $data , Constant::$GARMIN_SIGNATURE_TYPE['DailiesData']);
     
            $header = array();
            $header[] = 'Content-length: 0';
            $header[] = 'Content-type: application/json';
            $header[] = 'Authorization: OAuth oauth_consumer_key="'.$oauthData['oauth_consumer_key'].'",'
                    . 'oauth_token="'.$oauthData['oauth_token'].'",'
                    . 'oauth_signature_method="'.$oauthData['oauth_signature_method'].'",'
                    . 'oauth_timestamp="'.$oauthData['oauth_timestamp'].'",'
                    . 'oauth_nonce="'.$oauthData['oauth_nonce'].'",'
                    . 'oauth_version="'.$oauthData['oauth_version'].'",'
                    . 'oauth_signature="'.$oauthData['oauth_signature'].'"';
            
            $url = 'http://'.$data['host'].$data['call_path'].'?uploadStartTimeInSeconds='.$oauthData['uploadStartTimeInSeconds'].'&uploadEndTimeInSeconds='.$oauthData['uploadEndTimeInSeconds'];
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
            $result = curl_exec($ch); 
            
            return $this->renderSuccess(trans('messages.dailies_data_get_successfully'),$result);
            
        } 
        catch(\Exception $e){
                UtilityHelper::logExceptionWithObject(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    
    
    /**
        * 
        * Add Garmin Token and Secret for the User
        * 
        * @param $request contains oauthToken,tokenSecret
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if added user info successfully
        * 
    */
    public function garminResponse($request) {
        try{
//            $request = '{"dailies":[{"userAccessToken":"67ae3fe5-9c52-4756-930c-3cbaece76c52","uploadStartTimeInSeconds":1495520236,"uploadEndTimeInSeconds":1495520274,"callbackURL":"https://gcsapitest.garmin.com/wellness-api/rest/dailies?uploadStartTimeInSeconds=1495520236&uploadEndTimeInSeconds=1495520274"}]}';
            $request = json_decode($request,true); 
            $request = $request['dailies'][0];
            $userGarminInfo = UserGarminInfo::getGarminInfoFromAccessToken($request['userAccessToken']);
 
            $request_method = 'GET';
            $data = [
               'host' => 'gcsapitest.garmin.com/',
               'call_path' => 'wellness-api/rest/dailies',
               'consumer_key' => '895538fa-979e-436f-b5c9-bfdb98e714be',
               'consumer_secret' => 'ZALPNP0PuwfnfSgYKoeDtxgyJHRxH0mngwx',
               'oauth_token' => $request['userAccessToken'],
               'token_secret' => $userGarminInfo['user_token_secret'],
               'uploadStartTimeInSeconds' => $request['uploadStartTimeInSeconds'] ,
               'uploadEndTimeInSeconds' => $request['uploadEndTimeInSeconds'] , 
            ];

            $oauthData = $this->build_oauth_data($request_method, $data , Constant::$GARMIN_SIGNATURE_TYPE['DailiesData']);
     
            $header = array();
            $header[] = 'Content-length: 0';
            $header[] = 'Content-type: application/json';
            $header[] = 'Authorization: OAuth oauth_consumer_key="'.$oauthData['oauth_consumer_key'].'",'
                    . 'oauth_token="'.$oauthData['oauth_token'].'",'
                    . 'oauth_signature_method="'.$oauthData['oauth_signature_method'].'",'
                    . 'oauth_timestamp="'.$oauthData['oauth_timestamp'].'",'
                    . 'oauth_nonce="'.$oauthData['oauth_nonce'].'",'
                    . 'oauth_version="'.$oauthData['oauth_version'].'",'
                    . 'oauth_signature="'.$oauthData['oauth_signature'].'"';
            
            $url = 'http://'.$data['host'].$data['call_path'].'?uploadStartTimeInSeconds='.$oauthData['uploadStartTimeInSeconds'].'&uploadEndTimeInSeconds='.$oauthData['uploadEndTimeInSeconds'];
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
            $result = curl_exec($ch); 
            
            UserGarminData::insertGarminData($result, $userGarminInfo['user_id'],$request['uploadStartTimeInSeconds'],$request['uploadEndTimeInSeconds']);
            return $this->renderSuccess(trans('messages.garmin_data_captured_successfully'));
            
        } 
        catch(\Exception $e){
                UtilityHelper::logExceptionWithObject(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    
    /**
        * 
        * Add Garmin Token and Secret for the User
        * 
        * @param $request contains oauthToken,tokenSecret
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if added user info successfully
        * 
    */
    public function addUserTokenSecret($request) {
        try{
            $garminUserInformation = UserGarminInfo::updateDeviceData($request,Auth::user()->user_id);
            return $this->renderSuccess(trans('messages.garmin_token_saved_successfully'),$garminUserInformation);   
        } 
        catch(\Exception $e){
                UtilityHelper::logExceptionWithObject(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    /*
        * Function to create OAuth data (and the oauth_signature string) for use in making OAuth requests
        *
        * $request_method string required - the HTTP request method (GET | POST)
        * $data array with members:
        * consumer_key string required - Consumer key given by the Service Provider when you sign up on their site
        * consumer_secret string required - also given by the Service Provider during client sign up
        * host string - Service Provider base URL
        * call_path string - Service Provider API request endpoint
        * oauth_callback string - Consumer web address that Service Provider should redirect to at end of request
        * oauth_token string (not required for obtaining a Request Token) - value returned by Service Provider to oauth_callback URL
        * token_secret string (required for making user-approved API calls, in conjunction with an Access Token, to Service Provider endpoint) - also returned by Service Provider to oauth_callback URL
    */
    public function build_oauth_data($request_method, $data , $type) {
          $host            = $data['host'];
          $path            = $data['call_path']; 
          $request_method  = strtoupper( $request_method );
          $consumer_key    = $data['consumer_key'];
          $consumer_secret = $data['consumer_secret'];

          //collect the data (as an associative array)
          if($type == Constant::$GARMIN_SIGNATURE_TYPE['RequestToken']){
                $oauth_data = array(
                   'oauth_consumer_key'     => $consumer_key,
                   'oauth_nonce'            => (string)mt_rand(), // a stronger nonce is recommended
                   'oauth_signature_method' => 'HMAC-SHA1',
                   'oauth_timestamp'        => time(),
                   'oauth_version'          => '1.0'
                );
          }
          if($type == Constant::$GARMIN_SIGNATURE_TYPE['AccessToken']){
                $oauth_data = array(
                   'oauth_consumer_key'     => $consumer_key,
                   'oauth_token'            => $data['oauth_token'],
                   'oauth_signature_method' => 'HMAC-SHA1', 
                   'oauth_nonce'            => (string)mt_rand(), // a stronger nonce is recommended
                   'oauth_timestamp'        => time(),
                   'oauth_version'          => '1.0',
                   'oauth_verifier'          => $data['oauth_verifier'], 
                );
          }
          
          if($type == Constant::$GARMIN_SIGNATURE_TYPE['DailiesData']){
                $oauth_data = array(
                   'oauth_consumer_key'     => $consumer_key,
                   'oauth_token'            => $data['oauth_token'], 
                   'oauth_nonce'            => (string)mt_rand(), // a stronger nonce is recommended
                   'oauth_signature_method' => 'HMAC-SHA1',
                   'oauth_timestamp'        => time(),
                   'oauth_version'          => '1.0',
                   'uploadStartTimeInSeconds' => $data['uploadStartTimeInSeconds'],
                   'uploadEndTimeInSeconds'   => $data['uploadEndTimeInSeconds']
                );
          }

          if( isset($data['oauth_callback']) ) {
             $oauth_data['oauth_callback'] = $data['oauth_callback'];
          }

          
          
          $arr = array();

          //normalize the parameters - apply url encoding separately to each key/value pair
          foreach($oauth_data AS $key => $value)  {
             $encoded_key = rawurlencode($key);
             $encoded_val = rawurlencode($value);
             $arr[$encoded_key] = $encoded_val;
          }

          //normalize the parameters - sort the encoded data by key
          ksort($arr);

          //normalize the parameters - list the data members as string in <key>=<value> format and insert "&" between each pair
          // http_build_query automatically encodes, but our parameters are already encoded, 
          // so we urldecode to prevent double-encoding
          $querystring = urldecode(http_build_query($arr, '', '&'));

          //normalize the parameters - apply urlencoding to the resulting string
          $encoded_query_string = rawurlencode($querystring);

          $url = 'http://'. $host. $path;

          // mash everything together for the text to hash
          $base_string = strtoupper($request_method). "&". rawurlencode($url). "&". $encoded_query_string;

          if( isset($data['token_secret']) )  {
             $token_secret = $data['token_secret'];
             $key = rawurlencode($consumer_secret). "&". rawurlencode($token_secret);
          }
          else {
             $key = rawurlencode($consumer_secret)."&";
          }

          // generate the hash
          $signature = rawurlencode(base64_encode(hash_hmac('sha1', $base_string, $key, true)));

//          echo $signature; die;
          $oauth_data['oauth_signature'] = $signature;
          
          return $oauth_data;
       }
    
}    