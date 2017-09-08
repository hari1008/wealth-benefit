<?php

/*
 * File: WorkContract.php
 */

namespace App\Contracts;

interface GarminContract {
    
    public function getRequestToken();
    public function getAccessToken($request);
    public function getDailiesData($request);
    public function addUserTokenSecret($request);
    public function garminResponse($request);
}
