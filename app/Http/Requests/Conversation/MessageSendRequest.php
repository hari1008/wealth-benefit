<?php

/*
 * File: BookExpertCalendarRequest.php
 */

namespace App\Http\Requests\Conversation;

use App\Http\Requests\BaseFormRequest;

class MessageSendRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [
            
            'receiverId'=>'required|exists:users,user_id,deleted_at,NULL',
            'message'=>'required',
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