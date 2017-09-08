<?php

/*
 * File: GymController.php
 */

namespace App\Http\Controllers;
use App\Contracts\GymContract;
use App\Http\Requests\Gym\CheckInRequest;
use App\Http\Requests\Gym\CheckOutRequest;


class GymController extends BaseController {
    protected $gym;
    public function __construct(GymContract $gym) {
        parent::__construct();
        $this->gym = $gym;
        $this->middleware('jsonvalidate',['except' => ['getUserGymDetails']]);
    }
    
    
    /**
        * 
        * Does check in of user in gym 
        * 
        * @param $request contains information of gym beacons
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with all registered beacons of gym if successfully check in and failure otherwise
        * 
    */
    public function postUserCheckIn(CheckInRequest $request) {
        return $this->gym->postUserCheckIn($request);
    }
    
    /**
        * 
        * Does check out of user in gym 
        * 
        * @param $request contains information of gym and its checkout beacons
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if successfully checkout and failure otherwise
        * 
    */
    public function postUserCheckOut(CheckOutRequest $request) {
        return $this->gym->postUserCheckOut($request);
    }
    
    public function getUserGymDetails() {
        return $this->gym->getUserGymDetails();
    }
    
    
}
