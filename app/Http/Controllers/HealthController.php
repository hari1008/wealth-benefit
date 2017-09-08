<?php

/*
 * File: HealthController.php
 */


namespace App\Http\Controllers;
use App\Contracts\HealthContract;
use Illuminate\Http\Request;



class HealthController extends BaseController {
    protected $health;
    public function __construct(HealthContract $health) {
        parent::__construct();
        $this->health =$health;
        $this->middleware('jsonvalidate',['except' => ['getCategoryList','getQuestionList']]);
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
    public function getCategoryList(Request $request) {
        return $this->health->getHealthCategoryList();
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
    public function getQuestionList(Request $request) {
        
        return $this->health->getHealthQuestionList();
        
    }
    
}
