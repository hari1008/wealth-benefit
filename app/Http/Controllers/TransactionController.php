<?php

/*
 * File: TransactionController.php
 */

namespace App\Http\Controllers;
use App\Contracts\TransactionContract;
use App\Http\Requests\Transaction\AddTransactionRequest;



class TransactionController extends BaseController {
    protected $transaction;
    public function __construct(TransactionContract $transaction) {
        parent::__construct();
        $this->transaction = $transaction;
        $this->middleware('jsonvalidate',['except' => []]);
    }
    
    
     /**
        * 
        * Does insert a record transaction and update its sessions info
        * 
        * @param $data contains information of transaction
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with transaction object and failure otherwise
        * 
    */
    public function postAddUserTransaction(AddTransactionRequest $request) {
        return $this->transaction->postAddTransaction($request);
    }
    
    
    
    
}
