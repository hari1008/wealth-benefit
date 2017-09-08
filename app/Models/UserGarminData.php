<?php


/*
 * File: UserGarminData.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserGarminData extends Model {

    use SoftDeletes;

    protected $table = 'user_garmin_data';
    protected $primaryKey = 'user_garmin_data_id';
    
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
          'updated_at', 'deleted_at'
    ];
    
    /**
        * 
        * Adding garmin information of user  
        * 
        * @param $data contains token and secret
        * 
        * @return $information object
        * 
    */ 
    public static function insertGarminData($result,$userId,$startTimeInSeconds,$endTimeInSeconds){
            $data = json_decode($result,true);
            if(!empty($data[0])){
                $data = $data[0];
                $userGarminData = new UserGarminData();
                $userGarminData->user_id = $userId;
                $userGarminData->steps = $data['steps'];
                $userGarminData->distance_in_meters = $data['distanceInMeters'];
                $userGarminData->active_kilocalories = $data['activeKilocalories'];
                $userGarminData->start_time = date('Y-m-d H:i:s',$startTimeInSeconds);
                $userGarminData->end_time = date('Y-m-d H:i:s',$endTimeInSeconds);
                $userGarminData->overall_response = json_encode($result);
                $userGarminData->save();
                return $userGarminData;
            }
    }
}