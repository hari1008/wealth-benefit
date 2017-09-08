<?php namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Device;
use Illuminate\Routing\Router;
use App\Codes\Constant;
use App\Codes\StatusCode;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App;

class Apiauth {
    
    protected $user_id;
    protected $device_id;
    protected $user_token;
    protected $router;
    protected $app;
    public $attributes;
    function __construct(Router $router){
        $this->router=$router;
       
    }
    public function handle($request, Closure $next)
    {   
        
        if(!empty($request->header('language'))){
            if($request->header('language') == 'ar' || $request->header('language') == 'en'){
                App::setLocale($request->header('language'));
            }
        }

        $this->user_token = $request->header('userToken');

        $response_token_missing = array(
                'success' =>  "0",
                'message' =>trans('messages.token_missing'),
                'status'=> Response::HTTP_BAD_REQUEST,
        );
        
        $response = array(
                'success' =>  "0",
                'message' =>trans('messages.unauthorized'),
                'status'=> Response::HTTP_UNAUTHORIZED,
        );
        
        $response_del = array(
                'success' =>  "0",
                'message' =>trans('messages.user_deleted'),
                'status'=>  StatusCode::$USER_DELETED,
        );
        $response_not_found=array('Success' =>  "0",
                'message' =>trans('messages.user_not_found'),
                'status'=>  StatusCode::$USER_NOT_FOUND,
        );
        
        
        if($this->user_token!=''){
             $user_detail = Device::getUserByDevice($request)->first();
            
             if(is_object($user_detail)){
                 Auth::loginUsingId($user_detail->user_id);
               if(is_object(Auth::user())){
                
                    if(Auth::user()->deleted_at != Constant::$DELETED_NULL){ 
                        
                        return response()->json($response_del);
                    }
                }else{
              
                    return response()->json($response_not_found);
                }
         
                return $next($request);
             }
              
             if(is_object($user_detail)){
               Auth::loginUsingId($user_detail->user_id);
               
               if(is_object(Auth::user())){
                    if(Auth::user()->deleted_at != Constant::$DELETED_NULL){                   
                        return response()->json($response_del);
                    }
                    else{
                       
                        return $response =$next($request);
                    }
                }
                else{

                    return response()->json($response_not_found);
                }
             }
            else{
                return response()->json($response,$response['status']);
            }
        }
        else
        {
            return response()->json($response_token_missing,$response_token_missing['status']);
        }
    }
}