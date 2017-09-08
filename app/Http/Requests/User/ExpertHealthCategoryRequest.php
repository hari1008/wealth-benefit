<?php

/*
 * File: ExpertHealthCategoryRequest.php
 */

namespace App\Http\Requests\User;
use App\Http\Requests\BaseFormRequest;

class ExpertHealthCategoryRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [   
           'expertType' => 'required|In:1,2', 
           'expertHealthCategory' => 'required_if:expertType,2',
           'qualificationImageCount' => 'required',
           'bio'=>'required',
           'introductoryPrice' => 'required_if:expertType,1',
           'oneSessionPrice' => 'required_if:expertType,1',
           'tenSessionPrice' => 'required_if:expertType,1',
           'twentySessionPrice' => 'required_if:expertType,1'
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
