<?php

/*
 * File: ShowInterestRequest.php
 */

namespace App\Http\Requests\HealthProvider;
use App\Http\Requests\BaseFormRequest;

class ShowInterestRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [           
            'attributeId' => 'required',         
            //'text' => 'required'
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