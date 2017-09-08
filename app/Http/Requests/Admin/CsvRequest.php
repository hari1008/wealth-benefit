<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\BaseFormRequest;

class CsvRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    
    public function rules() {
        
        return [
            'import_file'=> 'required|file|mimes:csv,txt|validatefileext:csv',
            
        ];
    }
    public function messages()
    {
        return [
            'validatefileext'=>'Only csv file extension is allowed'
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