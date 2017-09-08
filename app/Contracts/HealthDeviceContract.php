<?php

/*
 * File: HealthDeviceContract.php
 */

namespace App\Contracts;

interface HealthDeviceContract {
    public function putSyncHealthDevice($request);
    public function getHealthDeviceData($request);
    public function putSyncHealthDevice1($request);
    public function getHealthDeviceData1($request);
    public function getHealthDeviceDataYearly();
    public function getLastSyncData();
    public function getCompleteDeviceData($request);
}
