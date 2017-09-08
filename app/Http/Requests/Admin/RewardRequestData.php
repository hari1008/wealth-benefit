<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\BaseFormRequest;

class RewardRequestData extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    
    public function rules() {
        
        return [
            'reward_name' => 'required',
            'reward_description' => 'required',
            'master_merchant_id' => 'required',
            'reward_image'=>'required_if:master_reward_id,""|image|max:5000',
            'master_reward_id'=>'required_unless:master_reward_id,""|exists:master_rewards,master_reward_id,deleted_at,NULL'
        ];
        
        
    }
    public function messages()
    {
        return [
            "name.alpha_spaces"     => "The name may only contain letters and spaces.",
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