<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\BaseFormRequest;

class GymRequestData extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    
    public function rules() {
        
        return [
            'gym_name' => 'required',
            'master_work_id' => 'required',
            'beacon.*.beacon_uuid' => 'required',
            'beacon.*.beacon_minor' => 'required|distinct',
            'beacon.*.beacon_major' => 'required|distinct',
        ];
        
        
    }
    public function messages()
    {
        return [
            'beacon.*.beacon_uuid.required' => 'Beacon UUID is required field',
            'beacon.*.beacon_major.required' => 'Beacon Major is required field',
            'beacon.*.beacon_minor.required' => 'Beacon Minor is required field',
            'beacon.*.beacon_major.distinct' => 'Beacon Major must be unique field',
            'beacon.*.beacon_minor.distinct' => 'Beacon Minor must be unique field'
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