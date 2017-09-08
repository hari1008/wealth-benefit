<?php

/*
 * File: ActivationCode.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SessionPrice extends Model
{
    use SoftDeletes;
    protected $table = 'session_prices';
    protected $primaryKey = 'session_price_id';
    
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
        'updated_at', 'deleted_at','created_at'
    ];
   
    protected $appends = [
       
    ];
    
     
    
    
    
    
    /**
        * 
        * Updating Session Price Info
        * 
        * @param $sessionPrices contains price of sessions
        * 
        * 
    */
    public static function updateExpertSessionPrice($sessionPrices,$expert_id)
    {
        $sessionPriceInfo = SessionPrice::where('expert_id',$expert_id)->first();
        if(!is_object($sessionPriceInfo)){
            $sessionPriceInfo = new SessionPrice();
        }
        $sessionPriceInfo->introductory = $sessionPrices['introductory'];
        $sessionPriceInfo->one_session = $sessionPrices['one_session'];
        $sessionPriceInfo->ten_session = $sessionPrices['ten_session'];
        $sessionPriceInfo->twenty_session = $sessionPrices['twenty_session'];
        $sessionPriceInfo->expert_id = $expert_id;
        $sessionPriceInfo->save();
    }
    
    public static function getSessionPrice($expert_id)
    {
        $sessionPriceInfo = SessionPrice::where('expert_id',$expert_id)->first();
        return $sessionPriceInfo;
    }
    
    public static function updateIntrodctoryPrice($introductoryPrice)
    {
        $sessionPriceInfo = SessionPrice::where('deleted_at',NULL)->update(['introductory'=>$introductoryPrice]);
    }
}
