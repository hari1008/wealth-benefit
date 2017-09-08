<?php

/*
 * File: ExpertCalendar.php
 */

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Codes\Constant;
use Illuminate\Support\Facades\DB;


class ExpertCalendar extends Authenticatable {

    use SoftDeletes;
    const PrimaryImage=1;

    protected $table = 'expert_calendar';
    protected $primaryKey = 'calendar_id';
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
          'created_at', 'updated_at', 'deleted_at'
    ];
    
    /**
        * 
        * Creating or Updating Expert Availability Calendar  
        * 
        * @param $bulk_array contains data for creating availability slots , $expertId contains Primary Key of expert(User)
        * 
        * @return true on success , false otherwise
        * 
    */
    public static function createUpdateExpertCalendarSlot($data){
        
        $expertCalendar = ExpertCalendar::find($data['calendarId']);
        if(!is_object($expertCalendar))
        {    
            $expertCalendar = new ExpertCalendar();
            $expertCalendar->expert_id = Auth::user()->user_id;
        }
        $expertCalendar->date = $data['date'];
        $expertCalendar->start_time = $data['startTime'];
        $expertCalendar->end_time = $data['endTime'];
        $expertCalendar->save();
        return $expertCalendar;  
     }
    public static function getAllExpertCalendarRecord($userId){
        
        $from = date("Y-m-d H:i:s");
        $to = \Date('Y-m-d H:i:s', strtotime("+".Constant::$TIME_DURATION_FOR_REOCCUR." days"));
        $expertCalendarSlots = ExpertCalendar::leftjoin('user_bookings', function ($join) {
                                                    $join->on('expert_calendar.expert_id', '=', 'user_bookings.expert_id');
                                                    $join->on('expert_calendar.date', '=', 'user_bookings.date');
                                                    $join->on('expert_calendar.start_time', '=', 'user_bookings.start_time');
                                                    $join->on('expert_calendar.end_time', '=', 'user_bookings.end_time');
                                                    $join->where('user_bookings.booking_status','1')  ;
                                                })
                                               ->select(DB::raw("expert_calendar.calendar_id,expert_calendar.expert_id,expert_calendar.date,expert_calendar.start_time,expert_calendar.end_time,IF(user_bookings.booking_id IS NULL,0,1) as is_booked"))
                                               ->where('expert_calendar.expert_id',$userId)      
                                               ->whereBetween(DB::raw("CONCAT(expert_calendar.date, ' ',expert_calendar.start_time)"), array( $from,$to))    
                                               ->get();

        if(is_object($expertCalendarSlots)){
            return $expertCalendarSlots; 
        }
        else{
            return NULL;
        }    
    }
     
    public static function findExpertCalendarRecord($calendar_id){
        
        $expertCalendar = ExpertCalendar::where('calendar_id',$calendar_id)->where('expert_id',Auth::user()->user_id)->first();
        if(is_object($expertCalendar)){
            return $expertCalendar; 
        }
        else{
            return false;
        }
            
    }
    public static function addBulkCalendarData($data){ 
        if(!empty($data)){
            ExpertCalendar::insert($data);
        }
    }
    
    public static function deleteExpertCalendarRecordByDate($date,$expert_id){
        
        ExpertCalendar::where('date',$date)
                        ->where('expert_id',$expert_id)
                        ->forceDelete();
        
    }
    
    public static function deleteMultipleExpertCalendarRecord($from,$to,$expert_id){
        ExpertCalendar::whereBetween('date', array( $from,$to))
                                               ->where('expert_id',$expert_id)
                                               ->forceDelete();
    }
    
    public static function isExpertCalenderSlotExist($data){
        return ExpertCalendar::where('expert_id',Auth::user()->user_id)->where("date",$data['date'])->where("start_time",$data['startTime'])->where("end_time",$data['endTime'])->count();
    }

}