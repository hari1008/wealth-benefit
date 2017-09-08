<?php

/*
 * File: GymContract.php
 */

namespace App\Contracts;

interface GymContract {
    
    public function postUserCheckIn($request);
    public function postUserCheckOut($request);
    public function getUserGymDetails();
}
