<?php

/*
 * File: UserWellnessAnswer.php
 */

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Codes\Constant;


class UserWellnessAnswer extends Authenticatable {

    

    protected $table = 'user_wellness_answers';
    protected $primaryKey = 'user_wellness_answer_id';
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
    
    protected $casts = [];
    
    
     
    public static function addWellnessAnswers($data,$age,$userId){
            $wellnessAnswers = new UserWellnessAnswer();
            $wellnessAnswers->user_id = $userId;
            $wellnessAnswers->gender = $data['gender'];
            $wellnessAnswers->dob = $data['dob'];
            $wellnessAnswers->height = $data['height'];
            $wellnessAnswers->height_unit = $data['heightUnit'];
            $wellnessAnswers->weight = $data['weight'];
            $wellnessAnswers->weight_unit = $data['weightUnit'];
            $wellnessAnswers->cigrattes_per_day = $data['cigrattesPerDay'];
            $wellnessAnswers->exercise_hour_per_week = $data['exerciseHourPerWeek'];
            $wellnessAnswers->exercise_intensity = $data['exerciseIntensity'];
            $wellnessAnswers->eating_habit = $data['eatingHabit'];
            $wellnessAnswers->blood_presure = $data['bloodPresure'];
            $wellnessAnswers->stress_level = $data['stressLevel'];
            $wellnessAnswers->sleep_hour = $data['sleepHour'];
            $wellnessAnswers->happiness = $data['happiness'];
            $wellnessAnswers->diabetes = $data['diabetes'];
            $wellnessAnswers->wellness_age = $age;
            $wellnessAnswers->save();  
     }
    
    

}