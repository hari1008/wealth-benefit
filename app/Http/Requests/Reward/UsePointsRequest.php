<?php

/*
 * File: RewardRedeemRequest.php
 */

namespace App\Http\Requests\Reward;
use App\Http\Requests\BaseFormRequest;

class UsePointsRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [           
            'points' => 'required|integer',
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