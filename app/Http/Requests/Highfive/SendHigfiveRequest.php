<?php

/*
 * File: SendHighfiveRequest.php
 */

namespace App\Http\Requests\Highfive;
use App\Http\Requests\BaseFormRequest;

class SendHigfiveRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [           
            'forUserId' => 'required|exists:users,user_id,deleted_at,NULL',         
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