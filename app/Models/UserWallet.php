<?php

/*
 * File: UserWallet.php
 */

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Codes\Constant;


class UserWallet extends Authenticatable {

    

    protected $table = 'user_wallets';
    protected $primaryKey = 'user_wallet_id';
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
    
    protected $casts = [];
    
    protected $appends = ['expired'];

    
    public function reward()
    {
        return $this->hasOne('App\Models\MasterReward','master_reward_id','master_reward_id')->withTrashed();
    }
    
    public function getExpiredAttribute()
    {
        if($this->expiry_date >= date('Y-m-d')){
            return 0;
        }  
        else{
            return 1;
        }
    }
    
    public static function findRewardInWallet($data){
            $reward = UserWallet::where('master_reward_id',$data['masterRewardId'])->where('expiry_date','>=',date('Y-m-d'))->where('user_id',Auth::user()->user_id)->first();  
            return $reward;
     }
    
    /**
        * 
        * Adding reward to wallet  
        * 
        * @param $data contains reward id , user id and tier info
        * 
        * @return $reward
        * 
    */ 
    public static function addRewardToWallet($data){
            $reward = new UserWallet();
            $reward->user_id = Auth::user()->user_id;
            $reward->master_reward_id = $data['masterRewardId'];
            $reward->tier = $data['tier'];
            $reward->expiry_date = date('Y-m-d', strtotime("+".$data['expiry']." days"));
            $reward->save();  
            return $reward;
     }
    
    /**
        * 
        * getting booking list of logged in user
        * 
        * @param NULL
        * 
        * @return objects of booked session in a paginated form
        * 
    */
    public static function getRewards($userId){
        if(empty($userId)){
            return [];
        }
        $rewards = UserWallet::with('reward')->where('user_id',$userId)->where('expiry_date','>=',date('Y-m-d', strtotime("-".Constant::$EXPIRY_DAYS_OF_WALLET_REWARD." days")))->paginate(Constant::$WALLET_PAGINATE);
        return $rewards;   
    }
    
    public static function removeReward($masterRewardId,$userId){
        if(empty($userId)){
            return [];
        }
        $walletReward = UserWallet::where('user_id',$userId)->where('master_reward_id',$masterRewardId)->first();
        if(is_object($walletReward)){
            $walletReward->delete();
        }
    }

}