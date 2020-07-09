<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class PermissionMiddleware {
    
    public function handle($request, Closure $next) {        
        if (Auth::user()->hasRole('Admin')) //If user has admin role
        {
            return $next($request);
        }
        if (Auth::user()->hasRole('User')) //If user has user role
        {
			//'posts/create'
			//dd(Auth::user()->hasPermissionTo('addPost'));
			//dd("middle",$request->segment(2));
			if ($request->is($request->segment(1).'/'.$request->segment(2)))//If user is creating a post
            {
                if (!Auth::user()->hasPermissionTo('addPost'))
                {
                   abort('401');
                } 
                else {
                   return $next($request);
                }
            }
        }
        return $next($request);
    }
}