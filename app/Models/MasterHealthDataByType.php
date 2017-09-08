<?php

/*
 * File: MasterHealthDatabyType.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MasterHealthDataByType extends Model {

    use SoftDeletes;

    protected $table = 'master_health_providers_insurances';
    protected $primaryKey = 'attribute_id';
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
    
    public function getLogoAttribute() {
        if ($this->attributes['logo'] && $this->attributes['logo']!='') {
            return $_ENV['AWS_SERVER_ROOT'] . $_ENV['AWS_BUCKET_NAME'] . $_ENV['HEALTH_IMAGE'] . $this->attributes['logo'];
        }
        return '';
    }
    public static function getHealthData($attributeId){
        return MasterHealthDataByType::where('attribute_id',$attributeId)->first();
    }
    public static function deleteHealthData($ids)
    {
         $deletedAt = time();
         return MasterHealthDataByType::whereIn('attribute_id',$ids)->update(array('deleted_at'=>$deletedAt));

    }
    
   
}