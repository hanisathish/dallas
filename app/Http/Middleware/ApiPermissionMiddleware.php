<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ApiPermissionMiddleware {

    public function handle($request, Closure $next) {

        if (Auth::user()->hasRole('Admin')) { //If user has admin role
            return $next($request);
        }
        
        if (Auth::user()->hasRole('Member')) { //If user has user role
            //'posts/create'
            //dd(Auth::user()->hasPermissionTo('addPost'));
            //dd("middle",$request->segment(2));
            
            if (!Auth::user()->hasPermissionTo('addPost')) {
                return response()->json(['error' => 'UnAuthorised'], 401);
            } else {
                return $next($request);
            }
        }
        return $next($request);
    }

}
