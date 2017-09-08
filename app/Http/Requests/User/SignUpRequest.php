<?php

/*
 * File: SignUpRequest.php
 */

namespace App\Http\Requests\User;
use App\Http\Requests\BaseFormRequest;

class SignUpRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [           
            'deviceType' => 'required',        
            'email'=>'required|email',
            'password' => 'required|between:6,15',
            'activationCode'=>'required'
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