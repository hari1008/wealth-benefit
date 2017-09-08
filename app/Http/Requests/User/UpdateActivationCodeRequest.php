<?php

/*
 * File: UpdateActivationCodeRequest.php
 */

namespace App\Http\Requests\User;
use App\Http\Requests\BaseFormRequest;

class UpdateActivationCodeRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [                
            'activationCode' => 'required|max:255',
            'userType' => 'required'
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