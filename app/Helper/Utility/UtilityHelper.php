<?php

namespace App\Helper\Utility;
use App\Modules\User\Model\Configuration;
use Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Codes\Constant;

/*
 * This is Utility Class of the Image
 */

class UtilityHelper {

    public static function generateRandomString($passwordLength) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%*&';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $passwordLength; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    /**
     * 
     * @param type $ptime
     * @return string
     */
    public static function timeStamp($ptime) {

        $ptime = strtotime($ptime);
        $etime = time() - $ptime;

        if ($etime <= 0) {
            //return '0 seconds';
            return 'Just now';
        }

        $a = array(12 * 30 * 24 * 60 * 60 => 'y',
            30 * 24 * 60 * 60 => 'M',
            24 * 60 * 60 => 'd',
            60 * 60 => 'hr',
            60 => 'min',
            1 => 's'
        );

        foreach ($a as $secs => $str) {

            $d = $etime / $secs;

            if ($d >= 1) {
                $r = round($d);
                if (in_array($str, array('s'))) {
                    return 'Just now';
                } else if (!in_array($str, array('min', 'hr', 'd'))) {
                    return date('m/d/Y', $ptime);
                } else {
                    //return $r.$str.($r > 1 ? 's' : '') . ' ago';
                    return $r . " " . $str . ' ago';
                }
            }
        }
    }
    
    
      public static function getProjectStatus($status) {
        $data = '';
        switch ($status) {
            case 1:
                $data = 'Active';
                break;
            case 2:
                $data = 'Pending';
                break;
            case 3:
                $data = 'Complete';
                break;
        }
        return $data;
    }
    
    
  
  public static function cvf_ps_generate_random_code($length) {

   $string = '';
   // You can define your own characters here.
   $characters = "23456789ABCDEFHJKLMNPRTVWXYZabcdefghijklmnopqrstuvwxyz";

   for ($p = 0; $p < $length; $p++) {
       $string .= $characters[mt_rand(0, strlen($characters)-1)];
   }

   return $string;

} 

public static function configurationValues($configurationId) {

    $value='';
   $configValue=  Configuration::where('configuration_id',$configurationId)->first();
   
   if(is_object($configValue)){
      $value= $configValue->value;
   }

   return $value;

} 

public static function startAgeForSetting($startAge){
    
            $string = str_replace(' ', '', $startAge);
  //explode the date to get month, day and year
  $birthDate = explode(",", $string);
  $Born = Carbon\Carbon::create($birthDate[1]);
            
$Age = $Born->diff(Carbon\Carbon::now())->format('%y');
     $start_age= (($Age-10)<18?18:($Age-10));
     
     return $start_age;
     //$end_age= (($Age+10)>65?65:($Age+10));  
    
}

public static function endAgeForSetting($endAge){
    
            $string = str_replace(' ', '', $endAge);
  //explode the date to get month, day and year
  $birthDate = explode(",", $string);
  $Born = Carbon\Carbon::create($birthDate[1]);
            
$Age = $Born->diff(Carbon\Carbon::now())->format('%y');
     
     
     $end_age= (($Age+10)>65?65:($Age+10)); 
     return $end_age;
    
}
public static function logException($method,$e) {
        Log::error(['method' => $method,'message' => $e->getMessage(),'created_at' => date("Y-m-d H:i:s")]);
}
public static function logExceptionWithObject($method,$e) {
        Log::error(['method' => $method, 'error' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()], 'created_at' => date("Y-m-d H:i:s")]);
}
public static function forgetSession($key){
     return Session::forget($key);
  }
  public static function getSession($key){
     return Session::get($key);
  }
  public static function putSession($key,$value){
      Session::put($key,$value);
  }
  public static function checkSession($key){
      if(Session::has($key)){
          return TRUE;
      }else{
          return FALSE;
      }
  }
  public static function formatDate($date){
      return date('Y-m-d',  strtotime($date));
  }
    
  public static function getPaging($result,$page){
        $total = count($result->get());
        $page_count=ceil($total/Constant::$EXPERT_LISTING_PAGINATE);
        $offset=($page-1)*Constant::$EXPERT_LISTING_PAGINATE;
        $resultList   = $result->skip($offset)->take(Constant::$EXPERT_LISTING_PAGINATE)->get();
        return array("resultList"=>$resultList,"page_count"=>$page_count,"total"=>$total);
    }
}
