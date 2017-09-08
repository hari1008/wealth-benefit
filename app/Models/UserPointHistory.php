<?php

/*
 * File: UserFeedback.php
 */

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;



class UserPointHistory extends Authenticatable
{
    protected $table = 'user_points_history';
    protected $primaryKey = 'point_history_id';
    
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
        'updated_at'
    ];
   
    protected $appends = [
       
    ];
    
    public static function insertPointHistory($point,$userId,$type){   
        $pointHistory = new UserPointHistory();
        $pointHistory->user_id = $userId;
        $pointHistory->points = $point;
        $pointHistory->type = $type;
        $pointHistory->save();
    }
}
