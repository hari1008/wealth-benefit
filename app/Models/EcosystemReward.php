<?php


/*
 * File: MasterReward.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Codes\Constant;


class EcosystemReward extends Model {

    

    protected $table = 'ecosystem_rewards';
    protected $primaryKey = 'ecosystem_reward_id';
    
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
    
    public function reward()
    {
        return $this->hasOne('App\Models\MasterReward','master_reward_id','master_reward_id');
    }
    
    
    public static function getRewards($ecosystemId){
        if(empty($ecosystemId)){
            return [];
        }
        $rewards = EcosystemReward::has('reward')->with('reward.users')->with('reward.wallet')->with('reward.merchant')->where('ecosystem_id',$ecosystemId)->orderBy('tier','asc')->paginate(Constant::$REWARD_PAGINATE);
        return $rewards;   
    }
    
    public static function getUnlockRewardsCount($ecosystemId,$tier){
        if(empty($ecosystemId)){
            return Constant::$ZERO;
        }
        $rewardsCount = EcosystemReward::with('reward.users')->where('ecosystem_id',$ecosystemId)->where('tier','<=',$tier)->count();
        return $rewardsCount;   
    }
    
}