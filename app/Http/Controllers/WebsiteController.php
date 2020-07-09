<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use Config;
use Camroncade\Timezone\Facades\Timezone;
use App\Models\Organization;
class WebsiteController extends Controller
{
   
    public function __construct(Request $request) {

        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->common_file_upload_path = Config::get('constants.FILE_UPLOAD_PATH');
//dd("org_domainpassport==",\Request::route('org_domain'),$request->org_domain,$request->route('org_domain'));        
        if (\Request::route('org_domain')) {
            $this->org_domain = \Request::route('org_domain');
        } else {
            $this->org_domain = \Request::segment(3);
        }

        //dd("URL : ".url('/login').'/'.$this->org_domain);
  //      dd($this->org_domain);
        //$this->crudOrganizationData = array();
        $whereArray = array('orgDomain' => $this->org_domain);
        $crudOrganization = Organization::crudOrganization($whereArray,null,null,null,null,null,null,'1')->get();
        //dd($crudOrganization);
        //if($crudOrganization->count() > 0){
        $this->crudOrganizationData = $crudOrganization;
        //}
        //dd($this->crudOrganizationData);
    }
    public function errorhome()
    {
    dd("errorhomesss");
    }
    public function index()
    {
    //dd($this->org_domain);
        $data['title'] = $this->browserTitle . "";
        $data['dateTimezone'] = Timezone::selectForm(
        '', 
        'Select Timezone', 
        ['class' => 'form-control', 'name' => 'orgTimeZone', 'id' => 'orgTimeZone']
        );        
        return view('fe.index',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = $this->browserTitle . " - Role Create";
        $data['permissions'] = Permission::all();//Get all permissions
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
        $role->save();
        if($request->permissions <> ''){
            $role->permissions()->attach($request->permissions);
        }
        return redirect()->route('roles.index')->with('success','Roles added successfully');
    }
   
     public function edit($id) {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
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
            'name'=>'required|max:10|unique:roles,name,'.$id,
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

    /**
     * @Function name : adultCheckin
     * @Purpose : adultCheckin
     * @Added by : Sathish
     * @Added Date : Jun 12, 2019
     */
    public function adultCheckin(Request $request) {        
        $data['title'] = $this->browserTitle . " - Adult Checkin";        
        return view('checkin.adult',$data);
    }

    /**
     * @Function name : childCheckin
     * @Purpose : childCheckin
     * @Added by : Sathish
     * @Added Date : Jun 12, 2019
     */
    public function childCheckin(Request $request) {        
        $data['title'] = $this->browserTitle . " - Child Checkin";        
        return view('checkin.child',$data);
    }

    /**
     * @Function name : notificationCheckin
     * @Purpose : notificationCheckin
     * @Added by : Sathish
     * @Added Date : Jun 12, 2019
     */
    public function notificationCheckin(Request $request) {        
        $data['title'] = $this->browserTitle . " - Notification Checkin";        
        return view('checkin.notification',$data);
    }

    /**
     * @Function name : reportCheckin
     * @Purpose : reportCheckin
     * @Added by : Sathish
     * @Added Date : Jun 12, 2019
     */
    public function reportCheckin(Request $request) {        
        $data['title'] = $this->browserTitle . " - Report Checkin";        
        return view('checkin.report',$data);
    }

    /**
     * @Function name : signup
     * @Purpose : signup
     * @Added by : Sathish
     * @Added Date : Jun 12, 2019
     */
    public function signup(Request $request) {
        
        $data['title'] = $this->browserTitle . " - Create Account";
        //$data['dateTimezone'] = Timezone::selectForm();
        $data['dateTimezone'] = Timezone::selectForm(
        '', 
        'Select Timezone', 
        ['class' => 'form-control', 'name' => 'orgTimeZone', 'id' => 'orgTimeZone']
        );
    
        
        return view('fe.signup', $data);
        
        
    }
}