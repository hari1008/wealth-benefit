<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\BaseFormRequest;

class ForgotPasswordRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [
            'email' => 'required|email|exists:users,email,deleted_at,NULL',
        ];
        
        
    }
    public function messages()
    {
        return [
            'email.exists' => trans('messages.user.not_found')
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