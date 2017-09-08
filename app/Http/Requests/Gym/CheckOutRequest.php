<?php

/*
 * File: CheckInRequest.php
 */

namespace App\Http\Requests\Gym;
use App\Http\Requests\BaseFormRequest;

class CheckOutRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [           
            'masterBeaconId' => 'required' ,
            'checkoutAt' => 'date_format:Y-m-d H:i:s'
        ];
        
        
    }
    public function messages()
    {
        return [
            'beacons.*.uuid.required' => 'UUID is mandatory', 
            'beacons.*.minor.required' => 'Minor is mandatory', 
            'beacons.*.major.required' => 'Major is mandatory', 
            'beacons.*.minor.integer' => 'Minor must be an integer', 
            'beacons.*.major.integer' => 'Major must be an integer', 
            
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