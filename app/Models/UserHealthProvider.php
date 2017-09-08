<?php

/*
 * File: UserHealthProvider.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Codes\Constant;
use App\Helper\Utility\CommonHelper;

class UserHealthProvider extends Model {

    use SoftDeletes;

    protected $table = 'user_health_provider_insurance';
    protected $primaryKey = 'id';
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
          'updated_at', 'deleted_at'
    ];
    
    /**
        * 
        * Capturing if user is interested in Health Provider
        * 
        * @param $data contains information about service provider in which user is intrested
        * 
        * @return interested object on success , false otherwise
        * 
    */
    public static function updateInterestedUserData($data){
        
            $userHealthProvider = UserHealthProvider::where('attribute_id',$data['attributeId'])->where('user_id',Auth::user()->user_id)->first();
            if(!is_object($userHealthProvider)){
                $userHealthProvider = new UserHealthProvider();
            }
            $userHealthProvider->user_id = Auth::user()->user_id;
            $userHealthProvider->attribute_id = $data['attributeId'];
            if(!empty($data['text'])){
                $userHealthProvider->text = CommonHelper::scriptStripper($data['text']);
            }
            $userHealthProvider->is_interested = Constant::$INTERESTED;
            $result = $userHealthProvider->save();
            if($result){
                return $userHealthProvider;
            }
            else {
                return false;
            }
    }
   
}