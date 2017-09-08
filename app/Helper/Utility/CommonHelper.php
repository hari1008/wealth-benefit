<?php
namespace App\Helper\Utility;
use App\Codes\Constant;
/*
 * This is Utility Class of the Image
 */

class CommonHelper
{
    public static function scriptStripper($input)
    {
       return preg_replace('#<script(.*?)>(.*?)</script>#is', '', $input);
    }
    
    /**
        * 
        * Calculate Age from Date Of Birth
        * 
        * @param $dob contains DOB 
        * 
        * @return Age calculated from given date of birth
        * 
    */
    public static function getAgeFromDOB($dob) {
        $from = new \DateTime($dob);
        $to   = new \DateTime('today');
        return $from->diff($to)->y;
    }
    
    /**
        * 
        * Convert Feet into Cm
        * 
        * @param $data contains Feet Value
        * 
        * @return Value in Cm
        * 
    */
    public static function getHeightInCm($heightInFeet) {
        $array = explode('.', $heightInFeet);
        $feet = $array[0];
        if(!empty($array[1])){
            $inches = $array[1];
        }
        else{
            $inches = 0;
        }
            
        $totalHeightInInches = ($feet*12) + $inches;
        $totalHeightInCm = $totalHeightInInches*2.54;
        return round($totalHeightInCm);
    }
    /**
        * 
        * Convert weight into KG from Lbs
        * 
        * @param $data contains Weight In Lbs
        * 
        * @return Weight in KG
        * 
    */
    public static function getWeightInKg($weightInLbs) {
        $totalWeightInKg = $weightInLbs*0.453592;
        return round($totalWeightInKg);
    }
    /**
        * 
        * Count time difference in minutes between given datetime and current datetime
        * 
        * @param $data contains from datetime
        * 
        * @return number of minutes
        * 
    */
    public static function countTimeDIffrenceInMinutes($datatime) {
        
            $datetime1 = strtotime($datatime);
            $datetime2 = strtotime(date("Y-m-d H:i:s"));
            $interval  = abs($datetime2 - $datetime1);
            return round($interval / 60);
    }
    
    public static function getFirstAndLastDateOfWeek($week,$year,$numberOfWeeks) {
        $dates = array();
        $timestamp = mktime( 0, 0, 0, 1, 1,  $year ) + ( $week * 7 * 24 * 60 * 60 );
        $timestamp_for_sunday = $timestamp - 86400 * ( date( 'N', $timestamp ));
        $sundayDateOfStartingWeek = date( 'Y-m-d', $timestamp_for_sunday );
        $sundayDateOfLastWeek = date('Y-m-d', strtotime('+'.$numberOfWeeks.' weeks', strtotime($sundayDateOfStartingWeek)));
        $suturdayDateOfLastWeek = date('Y-m-d', strtotime('-1days', strtotime($sundayDateOfLastWeek)));
        $dates['startDate'] = $sundayDateOfStartingWeek;
        $dates['endDate'] = $suturdayDateOfLastWeek;
        return $dates;
    }
    public static function countTimeDIffrenceInWeeks($startDate) {
        $startDate = new \DateTime($startDate);
        $interval = $startDate->diff(new \DateTime());
        return ceil($interval->days / 7);
    }
    public static function getWeekNumber($date){
        return date("W", strtotime("+1 day",strtotime($date)));
    }
    
    public static function addDayswithdate($date,$days){
        $date = strtotime("+".$days." days", strtotime($date));
        return  date("Y-m-d", $date);
    }
    
    public static function getUniqueToken(){
        $time = time();
        $str = 'abcdefghijklmnopqrstuvwxyz0123456789' . "$time";
        $shuffled = str_shuffle($str);
        //$token = bcrypt($shuffled);
        return $shuffled;
    }
    
    public static function getRandSecure($length,$except = [],$type = NULL)
    {
        $key = '';
        if($type == Constant::$NUMERIC){
            $keys = range(0, 9);
        }
        else{
            $keys = array_merge(range(0, 9), range('a', 'z'));
        }    
        
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        $key = strtoupper($key);
        
        if(in_array($key, $except)){
            $key = getRandSecure($length,$except);
        }
        return $key;
    }
    

}
