<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Router;

class LogInputs {
    
    protected $router;
    public $attributes;
    function __construct(Router $router){
        $this->router=$router;
    }
    public function handle($request, Closure $next)
    {
        
        $action_name=$this->router->getRoutes()->match($request)->getActionName();
        Log::info('Input Details', array('context'=>array('method'=>$action_name,'data'=>$request->all())));
        
        $response = $next($request);
        Log::info('Response Details', array('context'=>array('method'=>$action_name,'data'=>$response)));
        return $response;
        
    }
   
}