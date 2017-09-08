<?php

/*
 * File: IssueController.php
 */

namespace App\Http\Controllers;
use App\Contracts\IssueContract;
use App\Http\Requests\User\ReportIssueRequest;



class IssueController extends BaseController {
    protected $issue;
    public function __construct(IssueContract $issue) {
        parent::__construct();
        $this->issue = $issue;
        $this->middleware('jsonvalidate',['except' => ['getIssuesList']]);
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
    public function getIssuesList(){
            return $this->issue->getIssuesList();
    } 
    
    /**
        * 
        * Insert a issue when someone reported it
        * 
        * @param $request which contains information about issue faced by the user
        * 
        * @throws Exception If something happens during the process
        * 
        * @return reported issue object with success if inserted successfully otherwise failure 
        * 
    */
    public function postReportIssueUser(ReportIssueRequest $request) {  
        return $this->issue->postReportIssue($request);
    }
    
}
