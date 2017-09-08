<?php

/*
 * File: ForgotPasswordRequest.php
 */

namespace App\Http\Requests\User;
use App\Http\Requests\BaseFormRequest;

class ForgotPasswordRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [
           'email' => 'required|email'
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