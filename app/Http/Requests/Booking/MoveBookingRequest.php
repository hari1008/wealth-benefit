<?php

/*
 * File: MoveBookingRequest.php
 */

namespace App\Http\Requests\Booking;
use App\Http\Requests\BaseFormRequest;

class MoveBookingRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [
            'bookingId'=>'required',
            'date'=>'required|date_format:Y-m-d',
            'startTime'=>'required|date_format:H:i:s',
            'endTime'=>'required|date_format:H:i:s'
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