<?php

/*
 * File: WorkContractImpl.php
 */

namespace App\Implementers;
use App\Contracts\WorkContract;
use App\Models\MasterWorks;
use App\Implementers\BaseImplementer;
use App\Helper\Utility\UtilityHelper;
use Symfony\Component\HttpFoundation\Response;
use App\Models\MasterEcosystem;

class WorkContractImpl extends BaseImplementer implements WorkContract {
    
    public function __construct() {
    }
    
    /**
        * 
        * Provide list of works of the behalf of type
        * 
        * @param $data contains type of work
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with works objects if retrieved device data successfully
        * 
    */
    public function getWorks($data) {
        try{ 
            if(empty($data['ecosystemid'])){
                $works = MasterWorks::getWorks($data->input('type'));
            }
            else{
                $workIds = MasterEcosystem::getEcosystemWorks($data->input('ecosystemid'));
                $works = MasterWorks::getWorksById($workIds);
            }
            return $this->renderSuccess(trans('messages.work_retrieved_successfully'),$works);
        } 
        catch(\Exception $e){
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    
}    