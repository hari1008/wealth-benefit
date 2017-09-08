<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\BaseFormRequest;

class ChangePasswordRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    
    public function rules() {
        
        return [
            'oldPassword' => 'required|between:6,15',
            //'newPassword' => 'required|between:6,15|different:oldPassword|regex:"^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$"',
            'newPassword' => 'required|between:6,15|different:oldPassword',
            'confirmPassword'=>'required|same:newPassword'
        ];
        
        
    }
    public function messages()
    {
        return [
            //'newPassword.regex'=>'New password must contain atleast one alphabet and one number'
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