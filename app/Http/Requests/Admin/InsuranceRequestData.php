<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\BaseFormRequest;

class InsuranceRequestData extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    
    public function rules() {
        
        return [
            'name' => 'required|alpha_spaces|max:50',
            'description' => 'required|max:1000',
            'logo'=>'required_if:attribute_id,""|image|max:5000',
            'attribute_id'=>'required_unless:attribute_id,""|exists:master_health_providers_insurances,attribute_id,deleted_at,NULL'
           
        ];
        
        
    }
    public function messages()
    {
        return [
            "name.alpha_spaces"     => "The name may only contain letters and spaces.",
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