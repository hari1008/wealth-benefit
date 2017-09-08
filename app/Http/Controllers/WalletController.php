<?php

/*
 * File: WalletController.php
 */

namespace App\Http\Controllers;
use App\Contracts\WalletContract;
use App\Http\Requests\Wallet\AddRewardInWalletRequest;



class WalletController extends BaseController {
    protected $wallet;
    public function __construct(WalletContract $wallet) {
        parent::__construct();
        $this->wallet = $wallet;
        $this->middleware('jsonvalidate',['except' => ['getWalletRewardList']]);
    }
    
     /**
        * 
        * Provide Notification list of logged in user
        * 
        * @param null
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if everything went right
        * 
    */
    public function getWalletRewardList(){
            return $this->wallet->getWalletRewardList();
    } 
    
    /**
        * 
        * Insert a issue when someone reported it
        * 
        * @param $request which contains information about issue faced by the user
        * 
        * @throws Exception If something happens during the process
        * 
        * @return reported issue object with success if inserted successfully otherwise failure 
        * 
    */
    public function postAddRewardInWallet(AddRewardInWalletRequest $request) {  
        return $this->wallet->postAddRewardInWallet($request);
    }
    
}
