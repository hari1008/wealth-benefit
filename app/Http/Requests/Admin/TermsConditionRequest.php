<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\BaseFormRequest;
class TermsConditionRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    
    public function rules() {
        
        return [
            'description' => 'required',
            
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