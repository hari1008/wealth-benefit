<?php

/*
 * File: ExpertProfileRequest.php
 */

namespace App\Http\Requests\User;
use App\Http\Requests\BaseFormRequest;

class ExpertProfileRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [
            'firstName'=> 'required|max:25',
            'lastName'=> 'required|max:25',
            'city'=> 'required',
            'residenceCountry'=> 'required',
            'gender'=>'required|in:1,2',
            'dob'=> 'required|date_format:Y-m-d',
            'mobile'=> 'required',
            'expertType'=>'required|In:1,2',
            'workingLocation' => 'required',
            'workingLocationLat' => 'required',
            'workingLocationLong' => 'required',
            'expertContactNumber' => 'required',
            //'gymName' => 'required',
            'website' => 'required'
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