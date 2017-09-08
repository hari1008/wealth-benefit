<?php

/*
 * File: SignInRequest.php
 */

namespace App\Http\Requests\User;
use App\Http\Requests\BaseFormRequest;

class SendActivationRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [
            'email' => 'required|email|exists:master_activation_codes,mail,deleted_at,NULL'
        ];
    }
    public function messages()
    {
        return [
            'email.exists' =>'Given email does not found in any ecosystem.'
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