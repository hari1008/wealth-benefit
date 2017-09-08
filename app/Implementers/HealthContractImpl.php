<?php

/*
 * File: HealthContractImpl.php
 */

namespace App\Implementers;

use App\Contracts\HealthContract;
use App\Models\MasterHealthCategories;
use App\Models\MasterQuestions;
use App\Implementers\BaseImplementer;
use App\Helper\Utility\UtilityHelper;
use Symfony\Component\HttpFoundation\Response;

class HealthContractImpl extends BaseImplementer implements HealthContract {
    
    public function __construct() {
    }
    
    /**
        * 
        * Provide health category list
        * 
        * @param NULL
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with all categories if list retrieved successfully 
        * 
    */
    public function getHealthCategoryList() {
        try{ 
            $catList = MasterHealthCategories::all();
            return $this->renderSuccess(trans('messages.cat_list'), $catList);
        } 
        catch(\Exception $e){
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    
    /**
        * 
        * Provide Health Question list
        * 
        * @param NULL
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with all questions if question list retrieved successfully 
        * 
    */
    public function getHealthQuestionList() {
        try{ 
             $questionList = MasterQuestions::all();
             return $this->renderSuccess(trans('messages.question_list'), [$questionList]);
        } 
        catch(\Exception $e){
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    
}    