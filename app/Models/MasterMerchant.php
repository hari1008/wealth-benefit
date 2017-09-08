<?php


/*
 * File: MasterMerchant.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MasterMerchant extends Model {

    protected $table = 'master_merchants';
    protected $primaryKey = 'master_merchant_id';
    
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
    
    
    
    public static function getMerchantsList(){
        $merchants = MasterMerchant::orderBy('merchant_name','asc')->pluck('merchant_name','master_merchant_id');
        return $merchants;   
    }
    
    
    public static function deleteMerchantData($ids)
    {
         return MasterMerchant::whereIn('master_merchant_id',$ids)->delete();
    }
}