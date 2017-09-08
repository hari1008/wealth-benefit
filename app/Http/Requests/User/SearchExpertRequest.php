<?php

/*
 * File: SearchExpertRequest.php
 */

namespace App\Http\Requests\User;
use App\Http\Requests\BaseFormRequest;

class SearchExpertRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [
            //'expertName'=>'required',
            //'gender'=> 'required',
            'workingLocationLat' => 'required',
            'workingLocationLong' => 'required',
            'expertType' => 'required | In:1,2',
            'workId' => 'required_if:expertType,1',
            'maxPriceValue' => 'required_if:expertType,1',
            'minPriceValue' => 'required_if:expertType,1',
            'expertCategory' => 'required_if:expertType,2',
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