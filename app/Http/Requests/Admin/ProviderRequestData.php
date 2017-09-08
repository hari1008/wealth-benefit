<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\BaseFormRequest;

class ProviderRequestData extends BaseFormRequest {

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
            'attribute_id'=>'required_unless:attribute_id,""|exists:master_health_providers_insurances,attribute_id,deleted_at,NULL',
            'email'=>'required|email',
            'website'=>'required|url_validate',
            'delivery'=>'required',
            'opening_hrs'=>'required|less_than:closing_hrs',
            'closing_hrs'=>'required',
//            'closing_day'=>'required',
            'phone'=>'required|numeric'
           
        ];
        
    }
    public function messages()
    {
        return [
            'name.required'=>'Health provider name is required.',
            'description.required'=>'Health provider description is required.',
            'logo.required'=>'Health provider logo is required.',
            'website.required'=>'Health provider website is required',
            'email.required'=>'Health provider email is required.',
            'opening_hrs.required'=>'Please select opening hrs.',
            'closing_hrs.required'=>'Please select closing hrs.',
            'closing_day.required'=>'Please select closing day.',
            'phone.required'=>'Health provider phone is required.',
            'website.url_validate'=>'Please enter valid website url.',
            "name.alpha_spaces" => "The name may only contain letters and spaces.",
            "opening_hrs.less_than"=>"Opening hrs should be less than Closing hrs."
            
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