<?php

namespace App\Http\Controllers;
use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use DB;
use Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Redirect;

class RoleController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->userSessionData = Session::get('userSessionData');
    }
    public function index()
    {
        $data['title'] = $this->browserTitle . " - Role Management";
        $data['roles'] = Role::where('orgId' , $this->userSessionData['umOrgId'])->get();
        return view('roles.index',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = $this->browserTitle . " - Role Create";
        //$data['permissions'] = Permission::all();//Get all permissions
        $data['permissions'] = Permission::where('orgId' , $this->userSessionData['umOrgId'])->get();
        return view('roles.create', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|unique:roles|max:10',
            'permissions' =>'required',
            ]
        );
        $role = new Role();
        $role->name = $request->name;
        $role->orgId = $this->userSessionData['umOrgId'];
        $role->save();
        if($request->permissions <> ''){
            $role->permissions()->attach($request->permissions);
        }
        return redirect()->route('roles.index')->with('success','Roles added successfully');
    }
   
     public function edit($id) {
        $data['title'] = $this->browserTitle . " - Role Edit";
        $data['role'] = Role::findOrFail($id);
        //$permissions = Permission::all();
        $data['permissions'] = Permission::where('orgId' , $this->userSessionData['umOrgId'])->get();
        //return view('roles.edit', compact('role', 'permissions'));
        return view('roles.edit', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $role = Role::findOrFail($id);//Get role with the given id
    //Validate name and permission fields
        $this->validate($request, [
            //'name'=>'required|max:10|unique:roles,name,'.$id,
            'name'=>'required|max:100',
            'permissions' =>'required',
        ]);
        $input = $request->except(['permissions']);
        $role->fill($input)->save();
        if($request->permissions <> ''){
            $role->permissions()->sync($request->permissions);
        }
        return redirect()->route('roles.index')->with('success','Roles updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')
            ->with('success',
             'Role deleted successfully!');
    }
}