<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class BaseController extends Controller {

    protected $request_data = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
              
        $this->request_data = Request::all();
 
    }

    public function sendJsonResponse($response) {
        //To display a custom status
        if($response['status']>600)
        {
          return \Illuminate\Support\Facades\Response::json($this->convertToCamelCase($response))->header('Content-Type', "application/json");
        }
       else
       {
        return \Illuminate\Support\Facades\Response::json($this->convertToCamelCase($response),$response['status'])->header('Content-Type', "application/json");
       }
        
    }

    /**
     * Convert to Camel Case
     *
     * Converts array keys to camelCase, recursively.
     * @param  array  $array Original array
     * @return array
     */
    protected function convertToCamelCase($array) {
       
        $converted_array = [];
        foreach ($array as $old_key => $value) {
            if (is_array($value)) {
                $value = $this->convertToCamelCase($value);
            } else if (is_object($value)) {
                if ($value instanceof Model || (method_exists($value, 'toArray'))) {
                    $value = $value->toArray();
                }else {
                    $value = (array) $value;
                }
                $value = $this->convertToCamelCase($value);
            }
            $converted_array[camel_case($old_key)] = $value;
        }

        return $converted_array;
    }

    public function getData() {
       
        $this->postData = new \App\Helpers\Utility\ValidateJson();
        $this->request = $this->postData->jsonValidater();
    }

}
