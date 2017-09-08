<?php

/*
 * File: UpdateProfileRequest.php
 */

namespace App\Http\Requests\User;
use App\Http\Requests\BaseFormRequest;

class UpdateProfileRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [                   
            'firstName' => 'required|max:25',
            'lastName' => 'required|max:25',
//            'email'=>'required|email|unique:users',
//            'password' => 'required|between:6,15',
//            'isFacebook'=>'required|in:0,1',
//            'facebookId'=>'required_if:isFacebook,1',
            'countryCode'=>'required',
            'mobile'=>'required',
            'nationality'=>'required',
            'residenceCountry'=> 'required',
            'city'=>'required',
            'gender'=>'required|in:1,2',
            'dob'=> 'required|date_format:Y-m-d',
//            'userType'=>'required|in:1,2,3',
//            'language'=>'required|in:1,2',
//            'currentHealthDeviceId'=>'required|in:1,2,3',
//            'latitude'=>'required',
//            'longitude'=>'required',
//            'activationType'=>'required|in:1,2,3',
//            'activationCode'=>'required_if:userType,2,3'
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