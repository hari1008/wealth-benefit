<?php

/*
 * File: WellnessAnswerRequest.php
 */

namespace App\Http\Requests\User;
use App\Http\Requests\BaseFormRequest;

class WellnessAnswerRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *  heightUnit = 1 - cm , 2 - feet
     *  weightUnit = 1 - kg , 2 - lbs
     */
    public function rules() {
        return [           
            'gender'=>'required',
            'dob'=>'required | date_format:"Y-m-d"',
            'height'=>'required',
            'heightUnit'=>'required|in:1,2',  
            'weight'=>'required',
            'weightUnit'=>'required|in:1,2', 
            'cigrattesPerDay'=>'required',
            'exerciseHourPerWeek'=>'required|integer',
            'exerciseIntensity'=>'required|integer',
            'eatingHabit'=>'required|integer',
            'bloodPresure'=>'required|integer',
            'stressLevel'=>'required|integer',
            'sleepHour'=>'required',
            'happiness'=>'required|integer',
            'diabetes'=>'required|integer',
            'wellnessAge'=>'required'
        ];
    }
    public function messages()
    {
        return [
           'gender.required'=>'Gender is missing',
           'dob.required'=>'Date of Birth is missing',
           'dob.date_format'=>'Date of Birth does not match the format Y-m-d',
           'height.required'=>'Height is missing',
           'heightUnit.required'=>'Height Unit is missing',
           'weight.required'=>'Weight is missing',
           'weightUnit.required'=>'Weight Unit is missing',
           'cigrattesPerDay.required'=>'Number of cigrattes per day is missing',
           'exerciseHourPerWeek.required'=>'Number of exercise hours per week is missing',
           'exerciseIntensity.required'=>'Exercise Intensity is missing',
           'eatingHabit.required'=>'Eating Habit is missing',
           'bloodPresure.required'=>'Blood Presure is missing',
           'stressLevel.required'=>'Stress Level is missing',
           'sleepHour.required'=>'Number of sleeping hours are missing',
           'happiness.required'=>'Happiness Level is missing',
            
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
