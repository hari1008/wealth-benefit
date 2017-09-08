<?php

/*
 * File: CancelBookingRequest.php
 */

namespace App\Http\Requests\Notification;
use App\Http\Requests\BaseFormRequest;

class UpdateStatusNotificationRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [
            'notificationId'=>'required',
            
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