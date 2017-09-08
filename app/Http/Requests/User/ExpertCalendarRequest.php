<?php

/*
 * File: ExpertCalendarRequest.php
 */

namespace App\Http\Requests\User;
use App\Http\Requests\BaseFormRequest;

class ExpertCalendarRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [
            'date'=>'required|date_format:Y-m-d',
            'slots'=>'required_if:isAvailable,1',
            'isReoccur'=>'required',
            'isAvailable'=>'required',
            'slots.*.startTime'=>'required|date_format:H:i:s',
            'slots.*.endTime'=>'required|date_format:H:i:s',
            'days'=>'required_if:isReoccur,1'
        ];
    }
    public function messages()
    {
        return [
            'date.required'=>'Date is missing',
            'date.date_format'=>'Date Format is incorrect',
            'slots.*.startTime.required'=>'Start Time can not be empty',
            'slots.*.endTime.required'=>'End Time can not be empty',
            'slots.*.startTime.date_format'=>'Start Time Format is incorrect',
            'slots.*.endTime.date_format'=>'End Time Format is incorrect'
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