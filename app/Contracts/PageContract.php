<?php

/*
 * File: PageContract.php
 */

namespace App\Contracts;

interface PageContract {
    
    public function getTermsCondition();
    public function getPartners($request);
    
}
