<?php

/*
 * File: RewardRedeemRequest.php
 */

namespace App\Http\Requests\Payment;
use App\Http\Requests\BaseFormRequest;

class GetSplitPaymentRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [           
//            
//            'access_code' => 'required',
//            'request_type' => 'required',
//            'Command' => 'required',
//            'split_tdr_charge_type' => 'required',
//            'reference_no' => 'required',
//            'splitAmount' => 'required',
//            'subAccId' => 'required',
//            'merComm' => 'required',
        ];
        
        
    }
    public function messages()
    {
        return [
            
        ];
    }
    

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

}