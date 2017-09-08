<?php

/*
 * File: IssueContract.php
 */

namespace App\Contracts;

interface IssueContract {
    public function getIssuesList();
    public function postReportIssue($request);
}
