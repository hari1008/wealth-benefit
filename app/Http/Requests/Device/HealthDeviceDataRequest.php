<?php

/*
 * File: HealthDeviceDataRequest.php
 */

namespace App\Http\Requests\Device;
use App\Http\Requests\BaseFormRequest;

class HealthDeviceDataRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [           
            //'year' => 'required',         
            //'month' => 'required',
            //'mode'=>'required',
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