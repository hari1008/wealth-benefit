<?php


/*
 * File: MasterReward.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Codes\Constant;


class MasterReward extends Model {

    use SoftDeletes;

    protected $table = 'master_rewards';
    protected $primaryKey = 'master_reward_id';
    
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
    
    public function merchant()
    {
        return $this->hasOne('App\Models\MasterMerchant','master_merchant_id','master_merchant_id');
    }
    
    public function tiers()
    {
        return $this->hasMany('App\Models\EcosystemReward','master_reward_id','master_reward_id')
                ->select('tier')
                ->where('ecosystem_id', Auth::user()->ecosystem_id);
    }
    
    /**
     * The users that belong to the reward.
     */
    public function users()
    {
        $instance = $this->belongsToMany('App\Models\User','user_rewards');
        $instance->getQuery()->select('first_name');
        $instance->getQuery()->where('user_rewards.user_id',Auth::user()->user_id);
        return $instance;
    }
    
    /**
     * The users that belong to the user.
     */
    public function wallet()
    {
        $instance = $this->belongsToMany('App\Models\User','user_wallets');
        $instance->getQuery()->select('first_name');
        $instance->getQuery()->where('user_wallets.user_id',Auth::user()->user_id);
        return $instance;
    }
    
    public function getRewardImageAttribute() {
        if (!empty($this->attributes['reward_image']) && $this->attributes['reward_image']!='') { 
            if(env('STORAGE_TYPE') == 'S3'){
                return $_ENV['AWS_SERVER_ROOT'] . $_ENV['AWS_BUCKET_NAME'] . $_ENV['REWARD_IMAGE'] . $this->attributes['reward_image'];
            }
            else{
                return $_ENV['SERVER_ROOT'] . $_ENV['REWARD_IMAGE'] . $this->attributes['reward_image'];
            }
        }
        return '';
    }
    
    public static function getRewards($rewardIds){
        $rewards = MasterReward::with('users')->with('tiers')->whereIn('master_reward_id',$rewardIds)->orderBy('tier','asc')->paginate(Constant::$REWARD_PAGINATE);
        return $rewards;   
    }
    
    public static function getRewardByMerchant($merchantId){
        $rewardsData = [];
        if(empty($merchantId)){
            return $rewardsData;
        }
        $rewards = MasterReward::where('master_merchant_id',$merchantId)->get();
        foreach($rewards as $reward){
            $rewardsData[$reward['master_merchant_id']][$reward['master_reward_id']] = $reward['reward_name']; 
        }
        return $rewardsData;   
    }
    
    
    public static function redeemReward($reward,$userId){
        $reward->users()->sync( array('1'=> array( 'user_id' => $userId)));
    }
   
    public static function getRewardData($rewardId){
        return MasterReward::where('master_reward_id',$rewardId)->first();
    }
    
    public static function deleteRewardData($ids)
    {
        return MasterReward::whereIn('master_reward_id',(array)$ids)->delete();
    }
    
    public static function restoreRewardData($ids)
    {
         return MasterReward::withTrashed()->whereIn('master_reward_id',(array)$ids)->restore();
    }
}