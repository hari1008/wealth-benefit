<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Router;
use App\Codes\Constant;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class AdminAuth {
    
    protected $router;
    protected $app;
    public $attributes;
    function __construct(Router $router){
        $this->router=$router;
       
    }
    public function handle($request, Closure $next)
    {   
        
        $unauthenticateResponse = array(
                'success' =>  "0",
                'message' =>trans('messages.unauthenticate'),
                'status'=> Response::HTTP_BAD_REQUEST,
        );
        
        
        if(Auth::user()->user_type != Constant::$ADMIN){ 
            if(Auth::user()->user_type != Constant::$SUB_ADMIN){
                Auth::logout();
                Session::flush();
                return redirect()->back()->withErrors(trans('messages.unauthenticate'));
            }
            else{
                return response()->json($unauthenticateResponse);
            }
        }
        else{              
            return $next($request);
        }
                   
    }
}