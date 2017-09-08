<?php

/*
 * File: UserHealthDevices.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Codes\Constant;
use DateTime;
use App\Helper\Utility\CommonHelper;


class UserHealthDevices extends Model {

    use SoftDeletes;

    protected $table = 'user_health_devices';
    protected $primaryKey = 'health_id';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
          'created_at', 'deleted_at'
    ];
    
    protected $casts = [
        'steps' => 'integer',
        'gymVisits' => 'integer' ,
        'ptSessions' => 'integer' 
    ]; 
    
    /**
        * 
        * Synchronize device data by updating them if existing otherwise by updating
        * 
        * @param $data contains data send by devices
        * 
        * @return NULL
        * 
    */
    public static function updateDeviceData($data){
        
        foreach($data['result'] as $dateWiseData){
            $healthDevice =  UserHealthDevices::where('date',$dateWiseData['date'])->first();
            if(!is_object($healthDevice)){
                $healthDevice = new UserHealthDevices();
            }
            $healthDevice->user_id = Auth::user()->user_id;
            $healthDevice->date = $dateWiseData['date'];
            $healthDevice->calories_burned = $dateWiseData['caloriesBurned'];
            $healthDevice->distance_covered = $dateWiseData['distanceCovered'];
            $healthDevice->steps = $dateWiseData['steps'];
            $healthDevice->week_number = CommonHelper::getWeekNumber($dateWiseData['date']);
            $healthDevice->save();
            
        }
    }
    public static function updateDeviceData1($data){
        
        foreach($data['result'] as $dateWiseData){
            $healthDevice =  UserHealthDevices::where('date',$dateWiseData['date'])->where('user_id',Auth::user()->user_id)->first();
            if(!is_object($healthDevice)){
                $healthDevice = new UserHealthDevices();
            }
            $healthDevice->user_id = Auth::user()->user_id;
            $healthDevice->date = $dateWiseData['date'];
            $healthDevice->hour_key = NULL;
            $healthDevice->calories_burned = $dateWiseData['caloriesBurned'];
            $healthDevice->distance_covered = $dateWiseData['distanceCovered'];
            $healthDevice->steps = $dateWiseData['steps'];
            if(!empty($dateWiseData['syncTime'])){
                $healthDevice->sync_time = $dateWiseData['syncTime'];                
            }
            if(!empty($dateWiseData['healthDeviceName'])){
                $healthDevice->health_device_name = $dateWiseData['healthDeviceName'];                
            }

            $healthDevice->week_number = CommonHelper::getWeekNumber($dateWiseData['date']);
            $healthDevice->save();    
        }
    }
    public static function updateGymVisit($date,$hourKey,$weekNumber){
            $healthDeviceData =  UserHealthDevices::selectRaw('sum(gym_visits) as gym_visits')
                                                ->where('user_id',Auth::user()->user_id)
                                                ->groupBy('date')
                                                ->where('date',$date)
                                                ->first();
            if($healthDeviceData['gym_visits'] < Constant::$ONE){
                $healthDevice =  UserHealthDevices::where('date',$date)->where('user_id',Auth::user()->user_id)->first();
                if(!is_object($healthDevice)){
                    $healthDevice = new UserHealthDevices();
                }
                $healthDevice->user_id = Auth::user()->user_id;
                $healthDevice->date = $date;
                $healthDevice->hour_key = NULL;
                $healthDevice->gym_visits = Constant::$ONE;
                $healthDevice->week_number = $weekNumber;
                $healthDevice->save(); 
            }
    }
    
    /**
        * 
        * Getting Synchronize device data of logged in user 
        * 
        * @param NULL
        * 
        * @return synchronized data on the daily,weekly,monthly,yearly,current day basis
        * 
    */
    public static function getCompleteDeviceData($data){
        $now = new \DateTime('now');
        $weekNumber = CommonHelper::getWeekNumber($now->format('Y-m-d')); 
        $month = $now->format('m');
        $year = $now->format('Y');
        
        $userId = Auth::user()->user_id;
        $date = $now->format('Y-m-d');
        
        if(isset($data['userid'])){
            $userId = $data['userid'];
        }
        
        if(isset($data['date'])){
            $date = $data['date'];
        }
        $returnObj =  UserHealthDevices::getDeviceDailyData1($date, $userId);
        return $returnObj;
    }
    
    /**
        * 
        * Getting Synchronize device data of logged in user 
        * 
        * @param NULL
        * 
        * @return synchronized data on the daily,weekly,monthly,yearly,current day basis
        * 
    */
    public static function getDeviceData(){
        $now = new \DateTime('now');
        $weekNumber = CommonHelper::getWeekNumber($now->format('Y-m-d')); 
        $month = $now->format('m');
        $year = $now->format('Y');
        $userId = Auth::user()->user_id;
        
        $returnObj = [];
        $returnObj['currentDay'] =  UserHealthDevices::where('date',$now->format('Y-m-d'))->where('user_id','=',$userId)->get();
        $returnObj['daily'] =  UserHealthDevices::getDeviceDailyData($month, $year, $userId);
        $returnObj['weekly'] =  UserHealthDevices::getDeviceWeeklyData($weekNumber, $year ,$userId);
        $returnObj['monthly'] = UserHealthDevices::getDeviceMonthlyData($month, $year, $userId);
        $returnObj['yearly'] =  UserHealthDevices::getDeviceYearlyData($year, $userId);
        $returnObj['dailyGoals'] =  array('steps'=> Constant::$STEP_COUNT,'gymVisits'=> Constant::$GYM_VISIT_COUNT,'ptSessions'=> Constant::$PT_SESSION_COUNT);
        return $returnObj;
    }
    
    public static function getDeviceData1($userId){
        $now = new \DateTime('now');
        $weekNumber = CommonHelper::getWeekNumber($now->format('Y-m-d')); 
        $month = $now->format('m');
        $year = $now->format('Y');
        
        $returnObj = [];
        $returnObj['daily'] =  UserHealthDevices::getDeviceDailyData1($month,$userId);
        $returnObj['weekly'] =  UserHealthDevices::getDeviceWeeklyData1($weekNumber, $year, $userId);
        $returnObj['monthly'] = UserHealthDevices::getDeviceMonthlyData($month, $year, $userId);
        $returnObj['yearly'] =  UserHealthDevices::getDeviceYearlyData($year, $userId);
        $returnObj['dailyGoals'] =  array('steps'=> Constant::$STEP_COUNT,'gymVisits'=> Constant::$GYM_VISIT_COUNT,'ptSessions'=> Constant::$PT_SESSION_COUNT);
        return $returnObj;
    }
    
    public static function getDeviceDailyData($month,$year,$userId){
        $healthDeviceData =  UserHealthDevices::whereMonth('date','=',$month)
                                                ->whereYear('date','=',$year)
                                                ->where('user_id','=',$userId)
                                                ->orderBy('date','asc')
                                                ->get();
        return $healthDeviceData;
    }
    
    public static function getDeviceDailyData1($month,$userId){
        $healthDeviceData =  UserHealthDevices::whereMonth('date','=',$month)
                                                ->where('user_id','=',$userId)
                                                ->orderBy('date','asc')
                                                ->get();
        return $healthDeviceData;
    }
    public static function getDeviceWeeklyData($weekNumber,$year, $userId){
        $healthDeviceData =  UserHealthDevices::where('week_number','=',$weekNumber)
                                                ->whereYear('date','=',$year)
                                                ->where('user_id','=',$userId)
                                                ->orderBy('date','asc')
                                                ->get();
        return $healthDeviceData;
    }
    
    public static function getDeviceWeeklyData1($weekNumber, $year, $userId){
        $healthDeviceData =  UserHealthDevices::where('week_number',$weekNumber)
                                                ->whereYear('date',$year)
                                                ->where('user_id',$userId)
                                                ->selectRaw('sum(steps) as steps,sum(calories_burned) as caloriesBurned,sum(gym_visits) as gymVisits,sum(pt_sessions) as ptSessions,sum(distance_covered) as distanceCovered,week_number as weekNumber,date')
                                                ->groupBy('date')
                                                ->orderBy('date','asc')
                                                ->get();
        return $healthDeviceData;
    }
    
    public static function getDeviceMonthlyData($month,$year, $userId){
        $healthDeviceData =  UserHealthDevices::whereMonth('date','=',$month)
                                                ->whereYear('date','=',$year)
                                                ->where('user_id','=', $userId)
                                                ->selectRaw('sum(steps) as steps,sum(calories_burned) as caloriesBurned,sum(gym_visits) as gymVisits,sum(pt_sessions) as ptSessions,sum(distance_covered) as distanceCovered,week_number as weekNumber')
                                                ->groupBy('week_number')
                                                ->orderBy('weekNumber','asc')
                                                ->get();
        return $healthDeviceData;
    }
    
    public static function getDeviceYearlyData($year, $userId){
        $healthDeviceData =  UserHealthDevices::whereYear('date','=',$year)
                                                ->selectRaw('sum(steps) as steps,sum(calories_burned) as caloriesBurned,sum(gym_visits) as gymVisits,sum(pt_sessions) as ptSessions,sum(distance_covered) as distanceCovered,MONTH(Date) as month')
                                                ->where('user_id','=', $userId)
                                                ->groupBy(DB::raw("MONTH(Date)"))
                                                ->orderBy('month','asc')
                                                ->get();
        return $healthDeviceData;
    }
    
      
    public static function getLastSyncDate(){
        $lastSyncData =  UserHealthDevices::select('sync_time')
                                            ->where('user_id','=',Auth::user()->user_id)
                                            ->orderBy('date','desc')
                                            ->orderBy('hour_key','desc')
                                            ->first();
        if(is_object($lastSyncData)){
            return $lastSyncData;
        } 
      return null;
    }
    
    public static function getDataOfWeek($weekNumber,$year){
        $healthDeviceData =  UserHealthDevices::selectRaw('sum(steps) as steps,sum(calories_burned) as caloriesBurned,sum(gym_visits) as gymVisits,sum(pt_sessions) as ptSessions,sum(distance_covered) as distanceCovered,week_number as weekNumber,date')
                                                ->where('week_number',$weekNumber)
                                                ->whereYear('date',$year)
                                                ->where('user_id',Auth::user()->user_id)
                                                ->groupBy('week_number')
                                                ->first();
        return $healthDeviceData;
    }
    
    public static function getDataOfOneDay($date,$userId){
        
        $healthDeviceData =  UserHealthDevices::selectRaw('sum(steps) as steps,sum(calories_burned) as caloriesBurned,sum(gym_visits) as gymVisits,sum(pt_sessions) as ptSessions,sum(distance_covered) as distanceCovered,week_number as weekNumber,date')
                                                ->where('date',$date)
                                                ->where('user_id',$userId)
                                                ->groupBy('date')
                                                ->first();
        return $healthDeviceData;
    }
    
    public static function getDeviceDailyDataOfYear($year,$userId){
        $healthDeviceData =  UserHealthDevices::whereYear('date','=',$year)
                                                ->where('user_id','=',$userId)
                                                ->selectRaw('sum(steps) as steps,sum(calories_burned) as caloriesBurned,max(sync_time) as syncTime,sum(gym_visits) as gymVisits,sum(pt_sessions) as ptSessions,sum(distance_covered) as distanceCovered,week_number as weekNumber,date')
                                                ->groupBy('date')
                                                ->orderBy('date','asc')
                                                ->get();
        return $healthDeviceData;
    }
    
    public static function updatePtSession($hourKey,$userId,$date,$weekNumber,$time){
        $healthDevice =  UserHealthDevices::where('date',$date)->where('user_id',$userId)->first();
        if(!is_object($healthDevice)){
            $healthDevice = new UserHealthDevices();
            $healthDevice->user_id = $userId;
            $healthDevice->date = $date;
            $healthDevice->hour_key = NULL;
            $healthDevice->pt_sessions = Constant::$ONE;
            $healthDevice->week_number = $weekNumber;
            $healthDevice->save();
            $pushMessage = trans('messages.session_completed');
            static::sendPushNotification($pushMessage,Constant::$SESSION_COMPLETE_NOTIFICATION,$userId,$time);
        }
        else{
            if($healthDevice['pt_sessions'] != Constant::$ONE){
                $healthDevice->user_id = $userId;
                $healthDevice->date = $date;
                $healthDevice->hour_key = NULL;
                $healthDevice->pt_sessions = Constant::$ONE;
                $healthDevice->week_number = $weekNumber;
                $healthDevice->save();
                $pushMessage = trans('messages.session_completed');
                static::sendPushNotification($pushMessage,Constant::$SESSION_COMPLETE_NOTIFICATION,$userId,$time);
            }
        }
        
    }
    
    public static function sendPushNotification($pushMessage,$type,$reciever,$time){
            $deviceObj = new Device();
            $data = array(
                'sessionEndtime'=>$time,
                'type' => $type,
                'alert' => $pushMessage,
                'toUserId' => (array)$reciever,
                'time' => time());
            $deviceObj->sendPush($data);
    }
    
}