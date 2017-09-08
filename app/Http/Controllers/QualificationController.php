<?php

/*
 * File: QualificationController.php
 */

namespace App\Http\Controllers;
use App\Contracts\QualificationContract;
use App\Http\Requests\Qualification\DeleteQualificationRequest;



class QualificationController extends BaseController {
    protected $qualification;
    public function __construct(QualificationContract $qualification) {
        parent::__construct();
        $this->qualification = $qualification;
        $this->middleware('jsonvalidate',['except' => ['deleteQualification']]);
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
    public function deleteQualification($id){
        return $this->qualification->deleteQualification($id);
    } 
    
    
}
