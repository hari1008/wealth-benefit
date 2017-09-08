<?php

/*
 * File: UserFeedback.php
 */

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;



class UserFeedback extends Authenticatable
{
    protected $table = 'user_feedback';
    protected $primaryKey = 'feedback_id';
    
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
    public function userinfo() {
        return $this->belongsTo('App\Models\User', 'user_id', 'user_id');
    }
    public function expertinfo() {
        return $this->belongsTo('App\Models\User', 'expert_id', 'user_id');
    }
    public static function getRating($userId){
        return UserFeedback::where('expert_id', $userId)->avg('rating');   
    }
    
    public static function insertFeedback($data,$userId,$expertId){   
        $feedback = new UserFeedback();
        $feedback->user_id = $userId;
        $feedback->booking_id = $data['bookingId'];
        $feedback->expert_id = $expertId;
        $feedback->rating = $data['rating'];
        $feedback->save();
        return $feedback;  
    }
    
    
    public static function getFeedback($data,$userId,$expertId){
        
        $feedback = UserFeedback::where('user_id',$userId)
                                ->where('booking_id',$data['bookingId'])
                                ->where('expert_id',$expertId)
                                ->first();
        return $feedback;  
    }
    
   
}
