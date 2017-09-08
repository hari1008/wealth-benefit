<?php

/*
 * File: HighfiveContract.php
 */

namespace App\Contracts;

interface HighfiveContract {
    
    public function postSendHighfiveUser($request);
    public function getReceivedHighfive();
    
}
