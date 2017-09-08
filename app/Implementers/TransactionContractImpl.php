<?php

/*
 * File: TransactionContractImpl.php
 */

namespace App\Implementers;
use App\Contracts\TransactionContract;
use App\Implementers\BaseImplementer;
use App\Models\Transaction;
use App\Codes\Constant;
use App\Models\SessionPrice;
use App\Helper\Utility\UtilityHelper;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class TransactionContractImpl extends BaseImplementer implements TransactionContract {
    
    public function __construct() {
        
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
    public function postAddTransaction($data){
        try{
            
            $expertSessionsPrices = SessionPrice::getSessionPrice($data['expertId']);
            if($expertSessionsPrices[$data['typeOfSessions']] == $data['price']){
                $transaction = Transaction::insertTransaction($data);
                $result = $this->renderSuccess(trans('messages.transaction_added_successfully'),$transaction);
            }
            else{
                $result = $this->renderFailure(trans('messages.price_not_matched'), Response::HTTP_OK);
            }
//            need to check transaction first
//            $userExpertSession = UserSession::insertUserExpertSessionInfo($data);
//            $transaction['purchasedSessions'] = $userExpertSession;
            
        }
        catch(\Exception $e){
            DB::rollBack();
            UtilityHelper::logException(__METHOD__, $e);
            $result = $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
        return $result;
    }
     
}
