<?php

/*
 * File: PagesController.php
 */

namespace App\Http\Controllers;

use App\Contracts\PageContract;
use App\Http\Requests\Page\GetPartnerRequest;



class PageController extends BaseController {
    protected $page;
    public function __construct(PageContract $page) {
        parent::__construct();
        $this->page = $page;
        $this->middleware('jsonvalidate',['except' => ['getTermsCondition','getPartners']]);
    }
    
    
    /**
        * 
        * Will bring terms and conditions data
        * 
        * @param NULL
        * 
        * @throws Exception If something happens during the process
        * 
        * @return terms and conditions data
        * 
    */
    public function getTermsCondition(){
        return $this->page->getTermsCondition();
    }
    
    /**
        * 
        * Will bring terms and conditions data
        * 
        * @param NULL
        * 
        * @throws Exception If something happens during the process
        * 
        * @return terms and conditions data
        * 
    */
    public function getPartners(GetPartnerRequest $request){
        return $this->page->getPartners($request);
    }
    
    
}
