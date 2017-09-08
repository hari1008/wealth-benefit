<?php

/*
 * File: Transaction.php
 */

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Codes\Constant;
use App\Helper\Utility\CommonHelper;


class Transaction extends Authenticatable
{
    protected $table = 'user_transactions';
    protected $primaryKey = 'transaction_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
   
    protected $appends = [
       
    ];
    
    
    public static function insertTransaction($data){
            
        $allExistingTransactionPaymentId = array_unique(Transaction::pluck('transaction_payment_id')->toArray());
     
        $transaction = new Transaction();
        $transaction->user_id = Auth::user()->user_id;
        $transaction->expert_id = $data['expertId'];
        $transaction->number_of_sessions = $data['numberOfSessions'];
        $transaction->price = $data['price'];
        $transaction->type_of_session = $data['typeOfSessions'];
        $transaction->transaction_payment_id = CommonHelper::getRandSecure(Constant::$TRANSACTION_ID_LENGTH,$allExistingTransactionPaymentId);
        $transaction->save();
        return $transaction;
    }
   
}
