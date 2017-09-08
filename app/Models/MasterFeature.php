<?php


/*
 * File: MasterFeature.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;



class MasterFeature extends Model {

   

    protected $table = 'master_features';
    protected $primaryKey = 'feature_id';
    
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
          'created_at', 'updated_at','deleted_at'
    ];
    
    public static function getAllFeatures(){
        $features = MasterFeature::pluck('feature_name','feature_id')->toArray();
        return $features;   
    }
   
}