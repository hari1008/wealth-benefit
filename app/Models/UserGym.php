<?php

/*
 * File: UserGym.php
 */

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;



class UserGym extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'user_gyms';
    protected $primaryKey = 'user_gym_id';
    
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
        'updated_at','deleted_at'
    ];
   
    protected $appends = [
       
    ];
    
    /**
    * The attributes that should be casted to native types.
    *
    * @var array
    */
   protected $casts = [];
    
   public static function getCheckInDetials($gymId,$userId){
        return UserGym::where('master_gym_id',$gymId)->where('user_id',$userId)->whereDate('created_at',date('Y-m-d'))->first();
    }
   public static function checkIn($userGym,$gymId,$beaconId,$userId){
        if(!is_object($userGym)){
            $userGym = new UserGym();
        }
        $userGym->master_gym_id = $gymId;
        $userGym->checkin_beacon_id = $beaconId;
        $userGym->checkin_at = date('Y-m-d H:i:s');
        $userGym->user_id = $userId;
        $userGym->save();
    }
    
    
    public static function checkOut($userGym,$data){
        if(!is_object($userGym)){
            return NULL;
        }
        $userGym->checkout_beacon_id = $data['masterBeaconId'];
        if(!empty($data['checkoutAt'])){
            $userGym->checkout_at = $data['checkoutAt'];
        }
        else{
            $userGym->checkout_at = date('Y-m-d H:i:s');
        }
        $userGym->save();
        return $userGym;
    }
    
    public static function details($user){
        $userId = $user['user_id'];
        $userGym = UserGym::select('checkin_at','checkout_at','master_gym_id')->where('user_id',$userId)->whereDate('created_at',date('Y-m-d'))->orderBy('created_at','desc')->first();
        $visitCount =  UserGym::select(DB::raw('count(*) as visitCount'))->where('user_id',$userId)->where('checkout_at','!=',NULL)->first();
        $userGym['gymVisits'] = $visitCount['visitCount'];
        if(!empty($userGym['master_gym_id'])){
            $userGym['beacons'] = MasterBeacon::getBeaconsByGym($userGym['master_gym_id']);
        }
        $user['currentWeekGoal'] = $user->currentWeekGoal()->first();
        $userGym['user'] = $user;
        return $userGym;
    }
}
