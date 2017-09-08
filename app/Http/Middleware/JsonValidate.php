<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Config;

class JsonValidate {


    public function handle($request, Closure $next) {
     
      $this->jsonData = json_decode($request->getContent(), true);
    
     
        $response = array(
            'success' => 0,
            'message' => '',
            'statusCode' => '',
        );
        if (empty($this->jsonData)) {
            $response['message'] = trans('messages.emptyJson');
            $response['statusCode'] = Config::get('codes.emptyJson');
            return response()->json($response);
        } else {
            
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    $error = ''; // JSON is valid
                    break;
                case JSON_ERROR_DEPTH:
                    $error = trans('messages.jsonErrorDepth');
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $error = trans('messages.jsonErrorStateMismatch');
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $error = trans('messages.jsonErrorControlCharacter');
                    break;
                case JSON_ERROR_SYNTAX:
                    $error = trans('messages.jsonErrorSyntax');
                    break;
                // only PHP 5.3+
                case JSON_ERROR_UTF8:
                    $error = trans('messages.jsonErrorUTF8');
                    break;
                default:
                    $error = trans('messages.unknownJsonError');
                    break;
            }
            if (!empty($error)) {
                $response['message'] = $error;
                $response['statusCode'] = Config::get('codes.invalidJson');
                return response()->json($response);
            }
            
            return $response = $next($request);
        }
    }

}