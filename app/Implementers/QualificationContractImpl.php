<?php

/*
 * File: NotificationContractImpl.php
 */

namespace App\Implementers;
use App\Contracts\QualificationContract;
use App\Implementers\BaseImplementer;
use App\Models\ExpertQualification;
use App\Helper\Utility\UtilityHelper;
use Symfony\Component\HttpFoundation\Response;


class QualificationContractImpl extends BaseImplementer implements QualificationContract {
    
    public function __construct() {
        
    }
    
    /**
     * 
     * Provide Notification list of logged in user
     * 
     * @param null
     * 
     * @throws Exception If something happens during the process
     * 
     * @return success if everything went right
     * 
     */
    public function deleteQualification($id) {
        try {
                $result = ExpertQualification::deleteExpertQualification($id);
                if(!$result){
                    return $this->renderFailure(trans('messages.qualification_not_found'), Response::HTTP_OK);
                }
                else{
                    return $this->renderSuccess(trans('messages.qualification_deleted'));
                }
        } catch (\Exception $e) {
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }
}
