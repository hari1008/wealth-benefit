<?php

/*
 * File: UpdateInvitationStatusRequest.php
 */

namespace App\Http\Requests\User;
use App\Http\Requests\BaseFormRequest;

class UpdateInvitationStatusRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [ 
           'inviteId'=>'required',
           'status'=>'required|In:1,2,3'
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
