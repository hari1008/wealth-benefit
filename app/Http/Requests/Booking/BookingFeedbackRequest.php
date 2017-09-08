<?php

/*
 * File: BookExpertCalendarRequest.php
 */

namespace App\Http\Requests\Booking;

use App\Http\Requests\BaseFormRequest;

class BookingFeedbackRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [
            'bookingId'=>'required|exists:user_bookings,booking_id',
//            'expertId'=>'required|exists:users,user_id',
            'rating'=>'required|integer',
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