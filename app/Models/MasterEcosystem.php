<?php


/*
 * File: MasterEcosystem.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Codes\Constant;


class MasterEcosystem extends Model {

    use SoftDeletes;

    protected $table = 'master_ecosystems';
    protected $primaryKey = 'ecosystem_id';
    
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
          'updated_at'
    ];
    
    public function rewards()
    {
        return $this->hasMany('App\Models\EcosystemReward','ecosystem_id','ecosystem_id');
    }
    
    public function subadmin()
    {
        return $this->hasOne('App\Models\User','user_id','subadmin_user_id');
    }
    
    public function features()
    {
        return $this->belongsToMany('App\Models\MasterFeature', 'ecosystem_features', 'ecosystem_id', 'feature_id');
    }
    
    public function gyms()
    {
        return $this->belongsToMany('App\Models\MasterWorks', 'ecosystem_works', 'ecosystem_id', 'work_id');
    }
    
    public function codesCount()
    {
        $instance = $this->hasOne('App\Models\ActivationCode', 'ecosystem_id', 'ecosystem_id')->selectRaw('count(*) as code_count,ecosystem_id');
        $instance->getQuery();
        return $instance;
    }
    
    public function getLogoAttribute() {
        if (!empty($this->attributes['logo']) && $this->attributes['logo']!='') { 
                if(env('STORAGE_TYPE') == 'S3'){
                    return $_ENV['AWS_SERVER_ROOT'] . $_ENV['AWS_BUCKET_NAME'] . $_ENV['ECOSYSTEM_IMAGE'] . $this->attributes['logo'];
                }
                else{
                    return $_ENV['SERVER_ROOT'] . $_ENV['ECOSYSTEM_IMAGE'] . $this->attributes['logo'];
                }
        }
        return '';
    }
    
    public static function getEcosystemWorks($ecosystemId){
        if(empty($ecosystemId)){
            return [];
        }
        $ecosystem = MasterEcosystem::find($ecosystemId);
        if(is_object($ecosystem)){
            return $ecosystem->gyms()->pluck('master_works.work_id')->toArray();
        }
        else{
            return [];
        }
    }
    
    public static function getEcosystemRewards($ecosystemId){
        if(empty($ecosystemId)){
            return [];
        }
        $ecosystem = MasterEcosystem::find($ecosystemId);
        return $ecosystem->rewards()->pluck('ecosystem_rewards.master_reward_id')->toArray();
    }
    
    public static function getEcosystemList(){
        $ecosystems = MasterEcosystem::pluck('ecosystem_name','ecosystem_id');
        return $ecosystems;   
    }
    
    public static function getEcosystemByMerchantCode($merchantCode){
        $ecosystems = MasterEcosystem::where('merchant_code',$merchantCode)->first();
        return $ecosystems;   
    }
   
    public static function getEcosystemData($ecosystemId){
        return MasterEcosystem::withTrashed()->where('ecosystem_id',$ecosystemId)->with('subadmin')->with('rewards')->first();
    }
    
    public static function deleteEcosystemData($ids)
    {
        $ecosystems = MasterEcosystem::whereIn('ecosystem_id',(array)$ids)->first();
        $ecosystems->features()->detach();
        $ecosystems->rewards()->delete();
        $ecosystems->gyms()->detach();
        User::where('ecosystem_id',$ids)->update(['user_type' => Constant::$REGULAR_USER]);
        $ecosystems->forceDelete();
        return $ecosystems;
    }
    
    public static function changeEcosystemData($ids)
    {
        $ecosystem = MasterEcosystem::withTrashed()->where('ecosystem_id',$ids)->first();
        if($ecosystem['deleted_at']){
            User::where('ecosystem_id',$ids)->update(['ecosystem_status' => Constant::$YES]);
            $ecosystem->restore();
        }
        else{
            User::where('ecosystem_id',$ids)->update(['ecosystem_status' => Constant::$NO]);
            $ecosystem->delete();
        }
        return $ecosystem;
    }
    
    public static function getEcosystemLogo(){
        $logos = MasterEcosystem::where('logo','!=','')->pluck('logo');
        return $logos;   
    }
    
    public static function checkEcosystemExpiry()
    {
        $now = new \DateTime('now');
        $current_date = $now->format('Y-m-d');
        $ecosystem_ids = MasterEcosystem::where('expiry_date',$current_date)->pluck('ecosystem_id')->toArray();
        if(!empty($ecosystem_ids)){
            User::where('ecosystem_id',$ecosystem_ids)->update(['user_type' => Constant::$REGULAR_USER]);
            MasterEcosystem::where('expiry_date',$current_date)->delete();
        }
    }
}