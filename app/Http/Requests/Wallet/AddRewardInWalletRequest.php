<?php

/*
 * File: AddRewardInWalletRequest.php
 */

namespace App\Http\Requests\Wallet;
use App\Http\Requests\BaseFormRequest;

class AddRewardInWalletRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [           
           'masterRewardId'=>'required|exists:master_rewards,master_reward_id',
           'expiry'=>'required|integer',
           'tier'=>'required|integer', 
        ];
    }
    public function messages()
    {
        return [];
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
