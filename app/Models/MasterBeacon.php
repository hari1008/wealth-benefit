<?php


/*
 * File: MasterBeacon.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Codes\Constant;
use Illuminate\Database\Eloquent\SoftDeletes;


class MasterBeacon extends Model {

    use SoftDeletes;

    protected $table = 'master_beacons';
    protected $primaryKey = 'master_beacon_id';
    
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
    
    
    /**
     * Get the gym that owns the beacon.
     */
    public function gym()
    {
        return $this->belongsTo('App\Models\MasterGym','master_gym_id','master_gym_id');
    }
    
    public static function searchForBeacons($data,$gymIds){
        $query = MasterBeacon::whereIn('master_gym_id',$gymIds);
        $i = Constant::$ONE;
        $len = count($data['beacons']);
        
        foreach ($data['beacons'] as $beacons){
            
            if($len != Constant::$ONE){
                if ($i == Constant::$ONE) {
                    
                    $query->whereRaw('((`beacon_uuid` = ? and `beacon_major` = ? and `beacon_minor` = ?)',[$beacons['uuid'],$beacons['major'],$beacons['minor']]); 
                } else if ($i == $len) {
                    $query->orWhereRaw('(`beacon_uuid` = ? and `beacon_major` = ? and `beacon_minor` = ?))',[$beacons['uuid'],$beacons['major'],$beacons['minor']]); 
                }
                else{
                    $query->orWhereRaw('(`beacon_uuid` = ? and `beacon_major` = ? and `beacon_minor` = ?)',[$beacons['uuid'],$beacons['major'],$beacons['minor']]); 
                }
                $i++;
            }
            else{
                $query->whereRaw('((`beacon_uuid` = ? and `beacon_major` = ? and `beacon_minor` = ?))',[$beacons['uuid'],$beacons['major'],$beacons['minor']]); 
            }
        }
        return  $query->with('gym')->first(); 
    }
    
    public static function getBeaconsByGym($gymId){
        $beacons = MasterBeacon::where('master_gym_id',$gymId)->get(); 
        return $beacons;
    }
    
    public static function getBeaconsById($beaconId){
        $beacon = MasterBeacon::find($beaconId); 
        return $beacon;
    }
    
    public static function addBeaconData($beacons,$masterGymId)
    {
        MasterBeacon::where('master_gym_id',$masterGymId)->delete();
        foreach ($beacons as $beacon) {
            $beaconData[] = array(
                "beacon_uuid" => $beacon['beacon_uuid'],
                "beacon_major" => $beacon['beacon_major'],
                "beacon_minor" => $beacon['beacon_minor'],
                "master_gym_id" => $masterGymId
            );
        }
        MasterBeacon::insert($beaconData);
    }
   
}