<?php

/*
 * File: HealthProviderContract.php
 */

namespace App\Contracts;

interface HealthProviderContract {
    
    public function getHealthProviders($request);
    public function postShowIntrest($request);
}
