<?php

/*
 * File: MasterHealthProvider.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use App\Codes\Constant;


class MasterHealthProvider extends Model {

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
          'created_at', 'updated_at', 'deleted_at'
    ];
    
    protected $appends = ['aboutProvider'];
    
    public function getLogoAttribute() {
        if ($this->attributes['logo'] && $this->attributes['logo']!='') {
            return $_ENV['AWS_SERVER_ROOT'] . $_ENV['AWS_BUCKET_NAME'] . $_ENV['HEALTH_IMAGE'] . $this->attributes['logo'];
        }
        return '';
    }
    
    public function getClosingDayAttribute() {
      
        if ($this->attributes['closing_day'] && $this->attributes['closing_day']!='') {
            $weekDay = Config::get('constants.weekDay');
            return $weekDay[$this->attributes['closing_day']];
        }
        return '';
    }
    
    

    //implement the attribute
    public function getAboutProviderAttribute()
    {
        return $this->attributes['description'];
    }
    public function getDeliveryAttribute()
    {
        if($this->attributes['delivery'] == 1){
            return 'Y';
        }
        else{
            return 'N';
        }
    }
    
    public static function getHealthProviders($type){
        if($type == Constant::$HEALTH_PROVIDER){
            $paginate = Constant::$HEALTH_PROVIDER_PAGINATE;
        }
        else{
            $paginate = Constant::$INSURANCE_PROVIDER_PAGINATE;
        }
        $providers=  MasterHealthProvider::where('type',$type)->paginate($paginate);
        return $providers;
        
    }
    
    
    public static function getProviderLogo($type){
        $logos = MasterHealthProvider::where('type',$type)->where('logo','!=','')->pluck('logo');
        return $logos;   
    }
}