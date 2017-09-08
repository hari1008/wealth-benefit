<?php

/*
 * File: HealthProviderListRequest.php
 */

namespace App\Http\Requests\HealthProvider;
use App\Http\Requests\BaseFormRequest;

class HealthProviderListRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [           
            'type' => 'required|In:1,2'
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