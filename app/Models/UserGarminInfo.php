<?php


/*
 * File: UserGarminInfo.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserGarminInfo extends Model {

    use SoftDeletes;

    protected $table = 'user_garmin_information';
    protected $primaryKey = 'user_garmin_information_id';
    
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
    public static function updateDeviceData($data,$userId){
        
            $information = UserGarminInfo::where('user_id',$userId)->first();
            if(!is_object($information)){
                $information = new UserGarminInfo();
            }
            $information->user_id = $userId;
            $information->user_access_token = $data['userToken'];
            $information->user_token_secret = $data['userTokenSecret'];
            $information->save();
            return $information;
    }
    
    public static function getGarminInfoFromAccessToken($userAccessToken)
    {
         return UserGarminInfo::where('user_access_token',$userAccessToken)->first();
    }
}