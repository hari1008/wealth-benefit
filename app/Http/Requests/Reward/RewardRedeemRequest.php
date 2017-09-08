<?php

/*
 * File: RewardRedeemRequest.php
 */

namespace App\Http\Requests\Reward;
use App\Http\Requests\BaseFormRequest;

class RewardRedeemRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [           
            'masterRewardId' => 'required|exists:master_rewards,master_reward_id',
            'merchantCode' => 'required|max:6',
            'isWalletReward' => 'required|In:0,1',
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