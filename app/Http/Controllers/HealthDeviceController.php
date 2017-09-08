<?php

/*
 * File: HealthDeviceController.php
 */


namespace App\Http\Controllers;
use App\Contracts\HealthDeviceContract;
use App\Http\Requests\Device\SyncHealthDeviceRequest;
use App\Http\Requests\Device\HealthDeviceDataRequest;
use App\Http\Requests\Device\HealthDeviceCompleteDataRequest;

class HealthDeviceController extends BaseController {
    protected $device;
    public function __construct(HealthDeviceContract $device) {
        parent::__construct();
        $this->device =$device;
        $this->middleware('jsonvalidate',['except' => ['getSyncHealthDeviceData','getLastSyncHealthDevice','getSyncHealthDeviceData1',
            'getSyncHealthDeviceDataYearly','getCompleteHealthDeviceData']]);
    }
    
    /**
        * 
        * Insert/Update health device data 
        * 
        * @param $request contains data of device which need to be update 
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if successfully updated device data 
        * 
    */
    public function putSyncUserHealthDevice(SyncHealthDeviceRequest $request) {
        return $this->device->putSyncHealthDevice($request);
    }
    public function putSyncUserHealthDevice1(SyncHealthDeviceRequest $request) {
        return $this->device->putSyncHealthDevice1($request);
    }
    
    /**
        * 
        * Provide Health Device data on the basis of mode 
        * 
        * @param $request contains mode,month,year to bring data accordingly
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if retrieved device data successfully
        * 
    */
    public function getSyncHealthDeviceData(HealthDeviceDataRequest $request) {
        return $this->device->getHealthDeviceData($request);
    }
    public function getSyncHealthDeviceData1(HealthDeviceDataRequest $request) {
        return $this->device->getHealthDeviceData1($request);
    }
    
    
    /**
        * 
        * Provide Health Device data on the basis of mode 
        * 
        * @param $request contains mode,month,year to bring data accordingly
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if retrieved device data successfully
        * 
    */
    public function getCompleteHealthDeviceData(HealthDeviceCompleteDataRequest $request) {
        return $this->device->getCompleteDeviceData($request);
    }
    
    /**
        * 
        * Provide Health Device data of year 
        * 
        * @param NULL
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if retrieved device data successfully
        * 
    */
    public function getSyncHealthDeviceDataYearly() {
        return $this->device->getHealthDeviceDataYearly();
    }
    
    /**
        * 
        * Provide last sync device date or gives null if users never sync their device
        * 
        * @param NULL
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with date if retrieved device data successfully
        * 
    */
    public function getLastSyncHealthDevice() {
        return $this->device->getLastSyncData();
    }
    
}
