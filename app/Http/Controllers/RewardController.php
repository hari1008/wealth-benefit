<?php

/*
 * File: WorkController.php
 */


namespace App\Http\Controllers;
use App\Contracts\RewardContract;
use App\Http\Requests\Reward\RewardRedeemRequest;
use App\Http\Requests\Reward\UsePointsRequest;


class RewardController extends BaseController {
    protected $reward;
    public function __construct(RewardContract $reward) {
        parent::__construct();
        $this->reward = $reward;
        $this->middleware('jsonvalidate',['except' => ['getRewardList']]);
    }
   
    /**
        * 
        * Provide list of works of the behalf of type
        * 
        * @param $request contains type of work
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with works objects if retrieved device data successfully
        * 
    */
    public function getRewardList() {
        return $this->reward->getRewards();
    }
    
    public function postRewardRedeem(RewardRedeemRequest $request) {
        return $this->reward->postRewardRedeem($request);
    }
    
    public function postUsePoints(UsePointsRequest $request) {
        return $this->reward->postUsePoints($request);
    }
    
}
