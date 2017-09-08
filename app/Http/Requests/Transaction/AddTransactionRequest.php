<?php

/*
 * File: SendHighfiveRequest.php
 */

namespace App\Http\Requests\Transaction;
use App\Http\Requests\BaseFormRequest;

class AddTransactionRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [           
            'expertId' => 'required|integer', 
            'typeOfSessions' => 'required|string',
            'numberOfSessions' => 'required|integer',
            'price'=>'required|integer'
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