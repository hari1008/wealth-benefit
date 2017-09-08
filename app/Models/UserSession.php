<?php

/*
 * File: UserSession.php
 */

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Codes\Constant;


class UserSession extends Authenticatable {

    use SoftDeletes;

    protected $table = 'user_sessions';
    protected $primaryKey = 'user_sessions_id';
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
          'created_at', 'updated_at', 'deleted_at','user_sessions_id','user_id','expert_id'
    ];
    
    protected $casts = [
                        'sessions_available'=>'integer',
                        'introductory_available'=>'integer'
                        ];
    
    public static function getUserExpertSessionInfo($userId,$expertId){
        $userExpertSession  = UserSession::where('user_id',$userId)
                                            ->where('expert_id',$expertId)
                                            ->first();
        return $userExpertSession;
    }
    
    public static function insertUserExpertSessionInfo($data){
        $userExpertSession  = UserSession::where('user_id',$data['user_id'])
                                            ->where('expert_id',$data['expert_id'])
                                            ->first();
        if(is_object($userExpertSession)){
            $userExpertSession->sessions_available = $userExpertSession['sessions_available'] + $data['number_of_sessions'];
        }
        else{
            $userExpertSession  = new UserSession();
            $userExpertSession->sessions_available = $data['number_of_sessions'];
            $userExpertSession->user_id = $data['user_id'];
            $userExpertSession->expert_id = $data['expert_id'];
        }
        if($data['type_of_session'] == 'introductory'){
            $userExpertSession->introductory_available = Constant::$NOT_AVAILABLE;
        }
        $userExpertSession->save();
        return $userExpertSession;
    }
    
    
    /**
        * 
        * Update User sessions info
        * 
        * @param $userSessionObject , $numberOfSessions , $type = add , delete
        * 
        * @return NULL
        * 
    */ 
    public static function updateSessionCount($userSessionObject,$type,$numberOfSessions = 1){
        
        if($type == Constant::$ADD_SESSIONS){
            $userSessionObject->sessions_available = $userSessionObject['sessions_available'] + $numberOfSessions;
            $userSessionObject->save();
        }
        else{
            $userSessionObject->sessions_available = $userSessionObject['sessions_available'] - $numberOfSessions;
            $userSessionObject->save();
        }
        return $userSessionObject;    
    }

}