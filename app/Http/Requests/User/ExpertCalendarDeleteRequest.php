<?php

/*
 * File: ExpertCalendarRequest.php
 */

namespace App\Http\Requests\User;
use App\Http\Requests\BaseFormRequest;

class ExpertCalendarDeleteRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        // 1 = delete single record of given calendar_id , 2 = delete all records of given date
        return [
            'deleteType'=>'required|In:1,2',  
            'calendarId'=>'required_if:deleteType,1',
            'date'=>'date_format:Y-m-d|required_if:deleteType,2',
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