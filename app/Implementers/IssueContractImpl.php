<?php

/*
 * File: IssueContractImpl.php
 */

namespace App\Implementers;
use App\Contracts\IssueContract;
use App\Implementers\BaseImplementer;
use App\Helper\Utility\UtilityHelper;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterIssues;
use App\Models\ReportIssue;


class IssueContractImpl extends BaseImplementer implements IssueContract {
    
    public function __construct() {
        
    }
    
    /**
     * 
     * Provide list of works
     * 
     * @param null
     * 
     * @throws Exception If something happens during the process
     * 
     * @return success if everything went right
     * 
     */
    public function getIssuesList() {
        try {
            $issues = MasterIssues::getAllIssues();
            return $this->renderSuccess(trans('messages.issue_list_retirved_successfully'), $issues);
        } catch (\Exception $e) {
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }
    
    /**
     * 
     * Insert a issue when someone reported it
     * 
     * @param $data which contains information about issue faced by the user
     * 
     * @throws Exception If something happens during the process
     * 
     * @return reported issue object with success if inserted successfully otherwise failure 
     * 
     */
    public function postReportIssue($data) {
        try {
            $reportIssue = ReportIssue::createIssue($data, Auth::user()->user_id);
            if (is_object($reportIssue)) {
                $result = $this->renderSuccess(trans('messages.issue_report_added_successfully'), [$reportIssue]);
            } else {
                $result = $this->renderFailure(trans('messages.failed_to_report_issue'), StatusCode::$EXCEPTION, [false]);
            }
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            $result = $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
        return $result;
    }
}
