<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UserCoins;

class ApiHasWonAlreadyMiddleware {

    public function handle($request, Closure $next) {

        
        
        if (Auth::user()->hasRole('Member')) { //If user has user role
            
            if($request->segment(2) != ""){
                //Coins gained
                $whereUCArray = array('ucSourceEarned'=>$request->segment(2),'ucUserId'=>Auth::user()->id);//daily_quotes
                $crudUserCoins = UserCoins::crudUserCoins($whereUCArray,null,null,null,null,"1")->get();
                if($crudUserCoins->count() > 0){
                    return response()->json(['result_code'=>1,  'result' => "Coins Already Collected"]);
                }else{
                    return $next($request);
                }
            }
            
        }
        return $next($request);
    }

}
