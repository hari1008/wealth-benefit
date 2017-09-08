<?php


/*
 * File: MasterGym.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MasterGym extends Model {

    use SoftDeletes;

    protected $table = 'master_gyms';
    protected $primaryKey = 'master_gym_id';
    
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
          'updated_at','deleted_at'
    ];
    
    public function delete()
    {
        // delete all associated beacons
        $this->beacons()->delete();

        // delete the gym
        return parent::delete();
    }
    
    /**
     * Get the beacons for the gym.
     */
    public function beacons()
    {
        return $this->hasMany('App\Models\MasterBeacon','master_gym_id','master_gym_id');
    }
    
    /**
     * Get the gym that owns the beacon.
     */
    public function gym_group()
    {
        return $this->belongsTo('App\Models\MasterWorks','master_work_id','work_id');
    }
    
    public static function deleteGymData($ids)
    {
         $gyms = MasterGym::whereIn('master_gym_id',$ids);
         return $gyms->delete();
    }
    
    public static function getGymData($id)
    {
         return MasterGym::where('master_gym_id',$id)->with('beacons')->first();
    }
    
    public static function getGymIdsbyWork($workId)
    {   
        if(empty($workId)){
            return [];
        }    
        return MasterGym::whereIn('master_work_id',$workId)->pluck('master_gym_id')->toArray();
    }
    
    public static function getAllGymIds()
    {      
        return MasterGym::where('deleted_at',NULL)->pluck('master_gym_id')->toArray();
    }
    
    public static function addGymData($data)
    {
        if(!empty($data['master_gym_id'])){
            $masterGym = MasterGym::find($data['master_gym_id']);
        }
        else{
            $masterGym = new MasterGym();
        }
        
        $masterGym->gym_name = $data['gym_name'];
        $masterGym->gym_address = $data['gym_address'];
        $masterGym->gym_lat = $data['gym_lat'];
        $masterGym->gym_long = $data['gym_long'];
        $masterGym->zip_code = $data['zip_code'];
        $masterGym->master_work_id = $data['master_work_id'];
        if(!empty($data['gym_mail_id'])){
            $masterGym->gym_mail_id = $data['gym_mail_id'];
        }
        if(!empty($data['gym_phone'])){
            $masterGym->gym_phone = $data['gym_phone'];
        }
        if(!empty($data['gym_website'])){
            $masterGym->gym_website = $data['gym_website'];
        }
        $masterGym->save();
        return $masterGym['master_gym_id'];
    }
}