<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Organization;
class GetOrgnaizationDetailsMiddleware {

    public function handle($request, Closure $next) {

            $this->org_domain = $data['org_domain'] = $request->route('org_domain') != "" ? $request->route('org_domain') :$request->segment(3);
              
            $this->org_domain = trim($this->org_domain)==''?0:$this->org_domain;

            if($this->org_domain){
                $whereArray = array('orgDomain' => "$this->org_domain");//dd($whereArray);
                $crudOrganization = Organization::crudOrganization($whereArray,null,null,null,null,null,null,'1')->get();
                if ($crudOrganization->count() > 0) {
                    return $next($request);
                } else {
                    abort(404, $this->org_domain. ' - Organization Not Found');
                }
            }
            if($this->org_domain == null || $this->org_domain == ""){
                abort(404, " Organization Doesn't Exist");
            }
            //abort(403, 'Organization Name Missing');
            return $next($request);
            
            
        
    }

}
