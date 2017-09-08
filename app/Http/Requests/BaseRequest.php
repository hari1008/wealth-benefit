<?php

namespace App\Http\Requests;

use Symfony\Component\HttpFoundation\Response;

/**
 * This class is base class for all API request
 */
class BaseRequest extends Request {

    protected $response = null;

    /**
     * This method is used to send custom response when validation fails
     * @param array $errors
     * @return type
     */
    public function response(array $errors) {
      
       
        if (!$this->wantsJson()) {
            
            return parent::response($errors);
        } else {
            if (!$this->isJson()) {
                $this->response['result'] = array();
                $this->response['message'] = "Invalid JSON";
                $this->response['statusCode'] = Response::HTTP_BAD_REQUEST;
                return \Illuminate\Support\Facades\Response::json($this->response, Response::HTTP_BAD_REQUEST)->header('Content-Type', "application/json");
            } else {
                $first_error = '';
                foreach ($errors as $error) {
                    $first_error = $error[0];
                    break;
                }
                $this->response['result'] = array();
                $this->response['message'] = $first_error;
                $this->response['statusCode'] = Response::HTTP_BAD_REQUEST;
                $this->response['status'] = 0;
                return \Illuminate\Support\Facades\Response::json($this->response, Response::HTTP_BAD_REQUEST)->header('Content-Type', "application/json");
            }
        }
    }

//    protected function getValidatorInstance() {
//
//        $factory = $this->container->make('Illuminate\Validation\Factory');
//
//        if (method_exists($this, 'validator')) {
//            return $this->container->call([$this, 'validator'], compact('factory'));
//        }
//
////        return $factory->make(
////                        $this->json()->all(), $this->container->call([$this, 'rules']), $this->messages(), $this->attributes()
////        );
//
//        return $factory->make(
//                        $this->validationData(), $this->container->call([$this, 'rules']), $this->messages(), $this->attributes()
//        );
//    }

    public function getSegmentFromEnd($position_from_end = 1) {


        $segments = $this->segments();
        return $segments[sizeof($segments) - $position_from_end];
    }

    public function addParameter($array) {
        return $this->json()->add($array);
    }

}
