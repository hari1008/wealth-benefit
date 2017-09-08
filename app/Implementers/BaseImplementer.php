<?php

namespace App\Implementers;

use App\Http\Controllers\BaseController;
use App\Codes\StatusCode;
use Symfony\Component\HttpFoundation\Response;

class BaseImplementer extends BaseController {

    public function __construct() {
        $this->result = array();
        //App::make('user_id') =>It is used to access the app global variable. 
        //App::bound =>Used to check if value is set or not.
    }

    public function render() {
        $this->response = [
            'success' => $this->success,
            'message' => $this->message,
            'status' => $this->status,
            'result' => $this->result,
        ];
        return $this->sendJsonResponse($this->response);
    }

    public function renderSuccess($msg, $result = []) {
        $this->success = 1;
        $this->message = $msg;
        $this->status = Response::HTTP_OK;
        $this->result = $result;
        return $this->render();
    }

    public function validation_error($validator, $result = []) {

        $this->success = 0;
        $this->message = $validator->errors()->first();
        $this->status = StatusCode::$PARAMETER_MISSING;
        $this->result = $result;
        return $this->render();
    }

    public function model_not_found_error($msg, $result = []) {
        $this->success = 0;
        $this->message = $msg;
        $this->status = StatusCode::$USER_NOT_FOUND;
        $this->result = $result;
        return $this->render();
    }

    public function renderFailure($msg, $code, $result = []) {
        $this->success = 0;
        $this->message = $msg;
        $this->status = $code;
        $this->result = $result;
        return $this->render();
    }
     public function renderCustom($msg, $code, $result = []) {
        $this->success = 0;
        $this->message = $msg;
        $this->status = $code;
        $this->result = $result;
        return $this->render();
    }
    
    public function ajax_response($sucess, $message = [], $result = []) {
        $this->response = array(
            'Success' => $sucess,
            'Message' => $message,
        );
        if ($sucess == 1) {
            $this->response['Result'] = $result;
        }

        return json_encode($this->response);
    }
}
