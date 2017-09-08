<?php

/*
 * File: HighfiveController.php
 */

namespace App\Http\Controllers;
use App\Contracts\HighfiveContract;
use App\Http\Requests\Highfive\SendHigfiveRequest;



class HighfiveController extends BaseController {
    protected $highfive;
    public function __construct(HighfiveContract $highfive) {
        parent::__construct();
        $this->highfive = $highfive;
        $this->middleware('jsonvalidate',['except' => ['getReceivedHighfiveUser']]);
    }
    
    
    /**
        * 
        * Does insert a record when user send high five to another user
        * 
        * @param $data contains information of user to whom user want to send high five
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with high five object if successfully entered the data and failure otherwise
        * 
    */
    public function postSendHighfiveUser(SendHigfiveRequest $request) {
        return $this->highfive->postSendHighfiveUser($request);
    }
    
    /**
        * 
        * Does provide the list of all received high five of the user
        * 
        * @param NULL
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with high five objects if successfully retrieved 
        * 
    */
    public function getReceivedHighfiveUser() {
        return $this->highfive->getReceivedHighfive();
    }
    
    
}
