<?php

namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * This class is base class for all API request
 */
class BaseFormRequest extends FormRequest {

    protected $response = null;

    /**
     * This method is used to send custom response when validation fails
     * @param array $errors
     * @return type
     */
    public function response(array $errors) {
        $this->response['status'] = 0;
        $this->response['statusCode'] = Response::HTTP_OK;
        $this->response['message'] = '';
        $this->response['result'] = $errors;
        return \Illuminate\Support\Facades\Response::json($this->response, Response::HTTP_OK);

    }

}