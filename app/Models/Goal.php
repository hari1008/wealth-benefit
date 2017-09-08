<?php

/*
 * File: Highfive.php
 */

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Codes\Constant;
use App\Helper\Utility\CommonHelper;
use App\Models\UserHealthDevices;


class Goal extends Authenticatable
{
    protected $table = 'goals';
    protected $primaryKey = 'goal_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
   
    protected $appends = [
       
    ];
    
  
    /**
        * 
        * Provide number of achieved goals in given time period
        * 
        * @param $currentTier    : current tier because goal achievement depends on it
        *        $tierStartDate  : Start Date of tier period
        *        $tierEndDate    : End Date of tier period
        * 
        * @return NULL
        * 
    */
    public static function getWeeklyGoalAcheivedCount($userId,$tierStartDate,$tierEndDate){
        if(empty($userId) || empty($tierStartDate) || empty($tierStartDate)){
            return Constant::$ZERO;
        }
        $goals = Goal::select([DB::raw('count("is_weekly_goals_achieved") as weekly_goal')])
                ->where('user_id',$userId)
                ->where('is_weekly_goals_achieved', Constant::$YES)
                ->whereBetween('date', array($tierStartDate,$tierEndDate))
                ->first()->toArray();
        return (int)$goals['weekly_goal'];
    }
    
    /**
        * 
        * Update Goals with respect to the user
        * 
        * @param $currentTier   : current tier because goal achievement depends on it
        *        $userId        : for whom we need to update goals
        *        $points        : Reward points of the user
        *        $year          : Current Year 
        *        $date          : Current Date
        *        $weekNumber    : Current Week Number
        * 
        * @return Number of points 
        * 
    */
    public static function updateGoals($userId,$currentTier,$points,$date,$weekNumber){
     
        $goal = Goal::where('user_id',$userId)->where('week_number',$weekNumber)->first();
        
        $dailyGoalData = UserHealthDevices::getDataOfOneDay($date,$userId); 
        if( ($dailyGoalData['gymVisits'] >= Constant::$GYM_VISIT_COUNT) || ($dailyGoalData['ptSessions'] >= Constant::$PT_SESSION_COUNT) || ($dailyGoalData['steps'] >= Constant::$STEP_COUNT))
        {
            // daily goal acheived
            if(!is_object($goal)){
                //if it is a first daily goal of the week
                $goal = new Goal();
                $goal = Goal::saveGoal($currentTier,$goal, $userId, $weekNumber,$date,Constant::$ZERO,Constant::$ZERO,$dailyGoalData);  
                $pointsAcheived = Goal::calculatePointsAsPerTier($currentTier, $goal['goal_achieved']);
                $points = $points + $pointsAcheived;
                if($pointsAcheived > Constant::$ZERO){
                    UserPointHistory::insertPointHistory($pointsAcheived, $userId, Constant::$CREDIT);
                }
                $pushMessage = trans('messages.daily_goal_achieved');
                static::sendPushNotification($pushMessage,Constant::$ACHIEVED_DAILY_GOAL_NOTIFICATION,$userId);
            }
            else{
                if($goal['date'] != $date){
                    $goal->is_today_steps_achieved = Constant::$NO;
                    $goal->is_today_gym_visit_achieved = Constant::$NO;
                    $goal->is_today_pt_session_achieved = Constant::$NO;
                    $goal->save();
                }
                if(
                 (($goal['is_today_gym_visit_achieved'] == Constant::$NO) && ($dailyGoalData['gymVisits'] >= Constant::$GYM_VISIT_COUNT)) || 
                 (($goal['is_today_pt_session_achieved'] == Constant::$NO) && ($dailyGoalData['ptSessions'] >= Constant::$PT_SESSION_COUNT)) ||
                 (($goal['is_today_steps_achieved'] == Constant::$NO) && ($dailyGoalData['steps'] >= Constant::$STEP_COUNT))
                  )
                {
                    // only if no daily goal is updated for today
                    $goal = Goal::saveGoal($currentTier,$goal, $userId, $weekNumber,$date,$goal['goal_achieved'],$goal['health_score'],$dailyGoalData);
                    $pointsAcheived = Goal::calculatePointsAsPerTier($currentTier, $goal['goal_achieved']);
                    $points = $points + $pointsAcheived;
                    if($pointsAcheived > Constant::$ZERO){
                        UserPointHistory::insertPointHistory($pointsAcheived, $userId, Constant::$CREDIT);
                    }
                    $pushMessage = trans('messages.daily_goal_achieved');
                    static::sendPushNotification($pushMessage,Constant::$ACHIEVED_DAILY_GOAL_NOTIFICATION,$userId);
                }       
            }
        }
        return $points;
    }
    public static function sendPushNotification($pushMessage,$type,$reciever){
            $deviceObj = new Device();
            $data = array(
                'type' => $type,
                'alert' => $pushMessage,
                'toUserId' => (array)$reciever,
                'time' => time());
            $deviceObj->sendPush($data);
    }
    
    public static function getHealthScore($userId,$year){
          
        $goal = Goal::selectRaw('sum(health_score) as health_score')
                ->where('user_id',$userId)
                ->whereYear('date',$year)
                ->groupBy('user_id')
                ->first();
        return (int)$goal['health_score'];   
    }
    
    public static function saveGoal($currentTier,$goal,$userId,$weekNumber,$date,$goalAchieved = 0,$healthScore = 0,$dailyGoalData = []){
        if(($goal['is_today_steps_achieved'] == Constant::$NO) && ($dailyGoalData['steps'] >= Constant::$STEP_COUNT)){
            $goalAchieved ++;
            $healthScore ++;
            $goal->is_today_steps_achieved = Constant::$YES;
        }
        if(($goal['is_today_gym_visit_achieved'] == Constant::$NO) && ($dailyGoalData['gymVisits'] >= Constant::$GYM_VISIT_COUNT)){
            $goalAchieved ++;
            $healthScore ++;
            $goal->is_today_gym_visit_achieved = Constant::$YES;
        }
        if(($goal['is_today_pt_session_achieved'] == Constant::$NO) && ($dailyGoalData['ptSessions'] >= Constant::$PT_SESSION_COUNT)){
            $goalAchieved ++;
            $healthScore ++;
            $goal->is_today_pt_session_achieved = Constant::$YES;
        }
        $goal->user_id = $userId;
        $goal->week_number = $weekNumber;
        $goal->date = $date;
        $goal->goal_achieved = $goalAchieved;
        $goal->health_score = $healthScore;
        $goal->tier = $currentTier;
        if(Constant::$WEEKLY_GOALS[$currentTier] == $goalAchieved){
            $pushMessage = trans('messages.weekly_goal_achieved');
            static::sendPushNotification($pushMessage,Constant::$ACHIEVED_WEEKLY_GOAL_NOTIFICATION,$userId);
            $goal->is_weekly_goals_achieved = Constant::$YES;
        }
        $goal->save();
        return $goal;
    }
    
    
    /**
        * 
        * Calculate Point of the Week 
        * 
        * @param $currentTier   : current tier because goal achievement depends on it
        *        $points        : Reward points of the user
        *        $goals         : Number of goals of the week
        * 
        * @return $points
        * 
    */
    public static function calculatePointsAsPerTier($currentTier,$goals){
        
        $points = Constant::$ZERO;
        if($currentTier == Constant::$GOLD){
            $goalsNeedToAcheiveInWeek = Constant::$DAILY_GOALS_FOR_GOLD;
            $bonus = Constant::$BONUS_POINT_IN_GOLD;
        }  
        else if($currentTier == Constant::$SILVER){
            $goalsNeedToAcheiveInWeek = Constant::$DAILY_GOALS_FOR_SILVER;
            $bonus = Constant::$BONUS_POINT_IN_SILVER;
        }
        else{
            $goalsNeedToAcheiveInWeek = Constant::$DAILY_GOALS_FOR_BLUE;
            $bonus = Constant::$BONUS_POINT_IN_BLUE;
        } 
        
        if($goals < $goalsNeedToAcheiveInWeek){
            $points = Constant::$POINTS_FOR_EACH_DAILY_GOAL;
        }
        else if($goals == $goalsNeedToAcheiveInWeek){
            $points = Constant::$POINTS_FOR_EACH_DAILY_GOAL + $bonus;
        }
        return $points;
    }
   
}
