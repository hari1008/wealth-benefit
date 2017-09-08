<?php

/*
 * File: CancelBookingRequest.php
 */

namespace App\Http\Requests\Qualification;
use App\Http\Requests\BaseFormRequest;

class DeleteQualificationRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [
            'qualificationId'=>'required',
            
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