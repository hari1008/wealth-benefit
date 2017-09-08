<?php

/*
 * File: PaymentController.php
 */

namespace App\Http\Controllers;

use App\Http\Requests\Payment\PaymentRequest;
use App\Http\Requests\Payment\PaymentResponseRequest;
use App\Http\Requests\Payment\GetRSAKeyRequest;
use App\Http\Requests\Payment\GetSplitPaymentRequest;
use Illuminate\Http\Request;
use App\Contracts\PaymentContract;

class PaymentController extends BaseController {

    protected $payment;

    public function __construct(PaymentContract $payment) {
        parent::__construct();
        $this->payment = $payment;
    }

    public function postPaymentDone(PaymentRequest $request) {
        return $this->payment->bringPaymentForm($request);
    }

    public function postResponse(PaymentResponseRequest $request) {
        return $this->payment->captureResponse($request);
    }

    public function postSuccess(Request $request) {
        echo 'Transaction Successfully Done.';
        die;
    }

    public function postAborted(Request $request) {
        echo "<br>Thank you for shopping with us. We will keep you posted regarding the status of your order through e-mail";
        die;
    }

    public function postFailure(Request $request) {
        echo "<br>Thank you for shopping with us. However,the transaction has been declined.";
        die;
    }

    public function postCancel(Request $request) {
        echo 'Transaction Canceled';
        die;
    }

    public function getRSAKey(GetRSAKeyRequest $request) {
        return $this->payment->getRSAKey($request);
    }

    public function getSplitPayment(GetSplitPaymentRequest $request) {
        return $this->payment->getSplitPayment($request);
    }

}
