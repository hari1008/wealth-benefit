<?php

/*
 * File: InviteUserRequest.php
 */

namespace App\Http\Requests\User;
use App\Http\Requests\BaseFormRequest;

class InviteUserRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [           
           'inviteeEmails'=>'required_if:type,2',
           'invitedUserId'=>'required_if:type,1',
           'type'=>'required|In:1,2',
        ];
    }
    public function messages()
    {
        return [];
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
