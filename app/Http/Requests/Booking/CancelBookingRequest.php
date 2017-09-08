<?php

/*
 * File: CancelBookingRequest.php
 */

namespace App\Http\Requests\Booking;
use App\Http\Requests\BaseFormRequest;

class CancelBookingRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [
            'bookingId'=>'required',
            
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