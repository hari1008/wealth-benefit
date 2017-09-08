<?php

/*
 * File: ActivationCode.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class ExpertQualification extends Model
{
    use SoftDeletes;
    protected $table = 'expert_qualifications';
    protected $primaryKey = 'qualification_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'deleted_at','created_at'
    ];
   
    protected $appends = [
       
    ];
    
     
//    public function getQualificationImageAttribute() {
//        if (!empty($this->attributes['qualification_image']) && $this->attributes['qualification_image']!='') { 
//                if(env('STORAGE_TYPE') == 'S3'){
//                    return $_ENV['AWS_SERVER_ROOT'] . $_ENV['AWS_BUCKET_NAME'] . $_ENV['USER_QUALIFICATION_IMAGE'] . $this->attributes['qualification_image'];
//                }
//                else{
//                    return $_ENV['SERVER_ROOT'] . $_ENV['USER_QUALIFICATION_IMAGE'] . $this->attributes['qualification_image'];
//                }
//        }
//        return '';
//    }
    
    
    
    /**
        * 
        * Updating Expert Qualifications Doc
        * 
        * @param $images contains Images that we need to update
        * 
        * 
    */
    public static function addExpertQualification($data)
    {
        if(!empty($data)){
            ExpertQualification::insert($data);
        }
        $qualifications = ExpertQualification::where('expert_id',Auth::user()->user_id)->get();
        return $qualifications;
    }
    
    public static function deleteExpertQualification($qualificationId)
    {
        if(!empty($qualificationId)){
            $qualification = ExpertQualification::where('qualification_id', $qualificationId)->first();
            if(is_object($qualification)){
               return $qualification->forceDelete(); 
            }
            else{
                return false;
            }
            
        }
        
    }
    
    public static function updateExpertQualification($qualification_id,$data)
    {
        if(!empty($data)){
            ExpertQualification::where('qualification_id',$qualification_id)
            ->update($data);
        }
        
    }
    
    public static function getExpertQualifications($expert_id)
    {
            return ExpertQualification::where('expert_id',$expert_id)->get();
    }
    public static function getQulificationImageUrl($qulification_id)
    {
        return ExpertQualification::where('qualification_id',$qulification_id)->get();
    }
}
