<?php

/*
 * File: Highfive.php
 */

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;



class Highfive extends Authenticatable
{
    protected $table = 'user_highfive';
    protected $primaryKey = 'highfive_id';
    
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
        * Creating New High five if not existing otherwise will update it
        * 
        * @param $data contains description about who sends high five to whom
        * 
        * @return High five object
        * 
    */
    public static function insertHighfive($data){
        $highfive = Highfive::where('user_id','=',Auth::user()->user_id)->where('for_user_id',$data['forUserId'])->first();
        if(!is_object($highfive))
        {    
            $highfive = new Highfive();
            $highfive->user_id = Auth::user()->user_id;
            $highfive->for_user_id = $data['forUserId'];
            $highfive->save();
        }
        return $highfive;
    }
    
    public static function getAllHighfive(){
        $highfive = Highfive::select('users.user_id','users.first_name','users.last_name')
                              ->join('users', 'user_highfive.user_id', '=', 'users.user_id')
                              ->where('for_user_id','=',Auth::user()->user_id)->get();
        return $highfive;
    }
   
}
