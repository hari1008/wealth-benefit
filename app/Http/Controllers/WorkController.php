<?php

/*
 * File: WorkController.php
 */


namespace App\Http\Controllers;
use App\Contracts\WorkContract;
use App\Http\Requests\Work\WorkListRequest;


class WorkController extends BaseController {
    protected $work;
    public function __construct(WorkContract $work) {
        parent::__construct();
        $this->work = $work;
        $this->middleware('jsonvalidate',['except' => ['getWorkList']]);
    }
   
    /**
        * 
        * Provide list of works of the behalf of type
        * 
        * @param $request contains type of work
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with works objects if retrieved device data successfully
        * 
    */
    public function getWorkList(WorkListRequest $request) {
        return $this->work->getWorks($request);
    }
    
}
