<?php

/*
 * File: AddGarminTokenAndSecretRequest.php
 */

namespace App\Http\Requests\Garmin;
use App\Http\Requests\BaseFormRequest;

class AddGarminTokenAndSecretRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [           
            'userToken' => 'required',
            'userTokenSecret' => 'required'
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