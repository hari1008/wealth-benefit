<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\BaseFormRequest;

class EcosystemRequestData extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    
    public function rules() {
        
        return [
            'ecosystem_name' => 'required',
            'expiry_date' => 'required',
            'number_of_users' => 'required',
            'logo'=>'required_if:ecosystem_id,""|image|max:5000',
            'rewards.*.master_merchant_id' => 'required|integer',
            'rewards.*.master_reward_id' => 'required|integer',
            'rewards.*.tier' => 'required|integer',
            'rewards.*.expiry' => 'required|integer',
           
        ];
        
        
    }
    public function messages()
    {
        return [
            'rewards.*.master_merchant_id.required' => 'Merchant should not be empty',
            'rewards.*.master_reward_id.required' => 'Reward should not be empty',
            'rewards.*.tier.required' => 'Tier should not be empty',
            'rewards.*.expiry.required' => 'Expiry should not be empty',
            'rewards.*.expiry.integer' => 'Expiry(number of days) must be an integer value',
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