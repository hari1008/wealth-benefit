<?php

/*
 * File: WorkController.php
 */


namespace App\Http\Controllers;
use App\Contracts\GarminContract;
use App\Http\Requests\Garmin\GetGarminTokenRequest;
use App\Http\Requests\Garmin\GetDailiesDataRequest;
use App\Http\Requests\Garmin\AddGarminTokenAndSecretRequest;
use Illuminate\Http\Request;


class GarminController extends BaseController {
    protected $garmin;
    public function __construct(GarminContract $garmin) {
        parent::__construct();
        $this->garmin = $garmin;
        $this->middleware('jsonvalidate',['except' => ['getRequestToken','getAccessToken','getDailiesData','postGarminData']]);
    }
   
    /**
        * 
        * Provide the request token
        * 
        * @param NULL
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with token if retrieved device data successfully
        * 
    */
    public function getRequestToken() {
        return $this->garmin->getRequestToken();
    }
    
    /**
        * 
        * Provide the access token
        * 
        * @param $request contains oauthToken,tokenSecret,oauthVerifier
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with token if retrieved device data successfully
        * 
    */
    public function getAccessToken(GetGarminTokenRequest $request) {
        return $this->garmin->getAccessToken($request);
    }
    
    /**
        * 
        * Provide daily data
        * 
        * @param $request contains oauthToken,tokenSecret,uploadStartTimeInSeconds,uploadEndTimeInSeconds
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if retrieved data successfully
        * 
    */
    public function getDailiesData(GetDailiesDataRequest $request) {
        return $this->garmin->getDailiesData($request);
    }
    
    /**
        * 
        * Add Garmin Token and Secret for the User
        * 
        * @param $request contains oauthToken,tokenSecret
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if added user info successfully
        * 
    */
    public function postUserTokenSecret(AddGarminTokenAndSecretRequest $request) {
        return $this->garmin->addUserTokenSecret($request);
    }
    public function postGarminData(Request $request) {
        return $this->garmin->garminResponse($request);
    }
    
}
