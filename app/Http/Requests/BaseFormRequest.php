<?php

namespace App\Http\Requests;

use Symfony\Component\HttpFoundation\Response;

/**
 * This class is base class for all API request
 */
class BaseFormRequest extends \Illuminate\Foundation\Http\FormRequest {

    protected $response = null;

    /**
     * This method is used to send custom response when validation fails
     * @param array $errors
     * @return type
     */
    public function response(array $errors) {
        
        $messages = implode(' ', array_flatten($errors));
        $first_error = '';
        foreach ($errors as $error) {
            $first_error = $error[0];
            break;
        }
        
       


        $this->response['result'] =  array();
        $this->response['message'] = $first_error;
        $this->response['success'] = 0;
        //$this->response['statusCode'] = Response::HTTP_BAD_REQUEST;
        $this->response['status'] = Response::HTTP_BAD_REQUEST;
        
        return \Illuminate\Support\Facades\Response::json($this->response, Response::HTTP_BAD_REQUEST)->header('Content-Type', "application/json");
    }

}
