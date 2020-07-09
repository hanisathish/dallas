<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use DB;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
        $this->userSessionData = Session::get('userSessionData');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $data['title'] = $this->browserTitle . " - Dashboard";
        $data['userSessionData'] = $this->userSessionData;
        // get logged-in user
        $user = auth()->user();
        /*
        // get all inherited permissions for that user
        $permissions = $user->getAllPermissions();

        //dd(array_column($permissions->toArray(),'name'));
        $rolehere = $user->roles->first()->name;

                //by role 
        if(auth()->user()->hasRole('Adminstrator'))
        {
            //dd("Roles");
        } 
        //or by specific permission
        if(auth()->user()->hasPermissionTo('Accounting'))
        {
            dd("Permission");
        }
        //or
        if(auth()->user()->hasAnyPermission(['Nextgen Checkin','Accounting']))
        {
               dd("Permission22222");
        }

        dd(auth()->user()->getAllPermissions()->pluck('name'));
        if (auth::user()->can('view_school_setting')) {
          print 'hello';
        }
        foreach (auth::user()->roles as $role) {
          foreach ($role->permissions as $permission) {
            print($permission['name']);
            if(auth()->user()->hasAnyPermission([$permission['name']]))
                {
                       dd("Permission22222");
                }
          }
        }
        dd(auth::user()->hasDirectPermission('Small Group'));
        dd($rolehere->hasPermissionTo('Small Group'));
        dd(auth::user()->hasRole('Adminstrator')->hasPermissionTo('PermissionName'));
        */
        //dd($data['userSessionData']);
        return view('home', $data);
    }

}
