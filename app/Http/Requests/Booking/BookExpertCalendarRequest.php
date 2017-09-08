<?php

/*
 * File: BookExpertCalendarRequest.php
 */

namespace App\Http\Requests\Booking;

use App\Http\Requests\BaseFormRequest;

class BookExpertCalendarRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [
            'bookings'=>'required',
            'bookings.*.date'=>'required|date_format:Y-m-d',
            'bookings.*.startTime'=>'required|date_format:H:i:s',
            'bookings.*.endTime'=>'required|date_format:H:i:s',
            'bookings.*.expertId'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'bookings.*.date.required'=>'Date is missing',
            'bookings.*.date.date_format'=>'Date Format is incorrect',
            'bookings.*.startTime.required'=>'Start Time is missing',
            'bookings.*.endTime.required'=>'End Time is missing',
            'bookings.*.startTime.date_format'=>'Start Time Format is incorrect',
            'bookings.*.endTime.date_format'=>'End Time Format is incorrect',
            'bookings.*.expertId.required'=>'Expert Id is missing',
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