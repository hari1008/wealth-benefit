<?php

/*
 * File: SyncHealthDeviceRequest.php
 */

namespace App\Http\Requests\Device;
use App\Http\Requests\BaseFormRequest;

class SyncHealthDeviceRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [  
            'result'=>'required',
            'result.*.caloriesBurned' => 'required',         
            'result.*.distanceCovered' => 'required',
            'result.*.steps'=>'required',
            //'result.*.gymVisits'=>'required',
            //'result.*.goal'=>'required',
            'result.*.date'=>'required',
        ];
        
        
    }
    public function messages()
    {
        return [
            'result.*.caloriesBurned.required' => 'Calories Burned is missing',         
            'result.*.distanceCovered.required' => 'Distance Covered is missing',
            'result.*.steps.required'=>'Steps is missing',
            //'result.*.gymVisits.required'=>'Gym Visits missing',
            //'result.*.goal.required'=>'required',
            'result.*.date.required'=>'Date is missing',
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