<?php

/*
 * File: PaymentContract.php
 */

namespace App\Contracts;

interface PaymentContract {
    
    public function captureResponse($request);
    public function bringPaymentForm($request);
    public function getRSAKey($request);
    public function getSplitPayment($request);
}
