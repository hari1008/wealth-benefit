<?php

/*
 * File: ReportIssue.php
 */

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helper\Utility\CommonHelper;

class ReportIssue extends Authenticatable {


    protected $table = 'report_issues';
    protected $primaryKey = 'report_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
          'updated_at'
    ];
    public function reportedissueuser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'user_id');
    }
    public function reportedissuedetail() {
        return $this->belongsTo('App\Models\MasterIssues', 'issue_id', 'issue_id');
    }

    /**
        * 
        * Creating Issue 
        * 
        * @param $data contains issue id and its description given by the user
        * 
        * @return report issue object for success and false for failure
        * 
    */
    public static function createIssue($data,$userId){
        $reportModel = new ReportIssue();
        $reportModel->user_id = $userId;
        $reportModel->issue_id = $data['issueId'];
        $reportModel->description = CommonHelper::scriptStripper($data['description']);
        $result = $reportModel->save();
        if($result){
            return $reportModel;
        }
        else{
            return $result;
        }
    }

}