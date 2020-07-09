<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UserCoins;
use App\Models\CoinsWinLimit;

class ApiHasSourceTypePostMiddleware {

    public function handle($request, Closure $next) {


        if (Auth::user()->hasRole('Member')) { //If user has user role
            
            $whereUCArray = array('cwlType' => $request->input('ucSourceEarned')); //daily_quotes

            $crudCoinsWin = CoinsWinLimit::crudCoinsWin($whereUCArray,null,null,null,null,'1',null)->get();
            if ($crudCoinsWin->count() > 0) {
                return $next($request);
            } else {
                return response()->json(['result_code' => 2, 'result' => "Source Earned Type -ucSourceEarned- is Not available"]);
            }
            
        }
        return $next($request);
    }

}
