<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use Response;
class CustomRoleOrPermissionMiddleware
{
    public function handle($request, Closure $next, $roleOrPermission)
    {
        $userSessionData = Session::get('userSessionData');
        
        $permissionTable = DB::table('permissions')->where('orgId',$userSessionData['umOrgId'])->where('name',$roleOrPermission)->get();
        //$roleTable = DB::table('roles')->where('orgId',$userSessionData['umOrgId'])->where('name',$roleOrPermission)->get();
        $rolesOrPermissions = is_array($roleOrPermission)
                ? $roleOrPermission
                : explode('|', $roleOrPermission);
        
        if($permissionTable->count() > 0){
            $permissionTableArray = $permissionTable->toArray()[0];
            
            $user = $request->user();
            $roles = $user->roles;
            
            //dd(Session::get('userSessionData'),'asdsad');
//            if (Auth::guest()) {
//                throw UnauthorizedException::notLoggedIn();
//            }

            

            //$hasAllPermissions = $user->hasAllPermissions(array_column($permissions->toArray(),'name'));
      //$hasAllPermissions = $user->hasAllPermissions(7);
            
            $hasPermissionTo = $user->hasPermissionTo($permissionTableArray->id,null);
            //dd($hasPermissionTo);
            if (! $hasPermissionTo) {
                //throw UnauthorizedException::forRolesOrPermissions($rolesOrPermissions);
                $message = 'User does not have any of the necessary access rights.';
                abort(404, $message);                
            }
            //$hasRole = $user->hasRole($permissionTableArray->id,null);
            
//            if (! $user->hasAnyRole($rolesOrPermissions) && ! $user->hasAnyPermission($rolesOrPermissions)) {
//                throw UnauthorizedException::forRolesOrPermissions($rolesOrPermissions);
//            }
        }else{
            //throw UnauthorizedException::forRolesOrPermissions($rolesOrPermissions);
            //return Response::view('errors.403', [], 404);
            $message = 'Permission mismatch please login again.';
            //$data['exception'] = new static(403, $message, null, []);
            //return view('errors.403', $data);
            abort(403, $message);
        }

        return $next($request);
    }
}
