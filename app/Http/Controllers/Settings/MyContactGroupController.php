<?php
namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use DB;
use Config;

use DataTables; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\MyContactGroup;
use App\Models\MyContact;
use App\Models\ContactGroupMap;
use Illuminate\Http\Response;

class MyContactGroupController extends Controller
{

    public function __construct()
    {
        
        

        $this->middleware(function ($request, $next) {
            $this->userguard = Auth::guard('web')->user();

            return $next($request);
        });
    }

    /**
     * @Function name : index
     * @Purpose :  MyContactGroups listing
     * @Added by : Sathish    
     * @Added Date : Jul 03, 2019
     */
    public function index(Request $request)
    {
        $data['title'] = "MyContactGroup";

        return view('settings.mycontactgroup.index',$data);
    }

    /**
     * @Function name : listMyContactGroup
     * @Purpose :  MyContactGroups listing
     * @Added by : Sathish    
     * @Added Date : Jul 03, 2019
     */
    public function getMyContactGroupList()
    {
        $result = array();
        if($this->userguard->roles[0]->name == "superadmin"){
            $whereArray = null;
        }else{
            $whereArray = array('contact_group.createdBy' => $this->userguard->id);    
        }

        $dataObj['groupBy'] = array('contact_group.id');
        $dataObj['orderBy'] = array('contact_group.group_name'=>'asc');

        $mycontactgroups = MyContactGroup::selectMyContactGroupDetail($whereArray,null,null,null,null,$dataObj)->get();
        
        $i = 1;
        //check in total if any meeting available
        
        
        foreach ($mycontactgroups as $mycontactgroup) {
             
            $row = array();

            $row[] = $mycontactgroup->id;
            $row[] = $mycontactgroup->group_name;
            $row[] = $mycontactgroup->grpcontactcount;

            //showConfirm
            $button_html = '<a data-groupid="'.$mycontactgroup->id.'" 
            data-groupname="'.$mycontactgroup->group_name.'" 
            href="#modal-mycontactgroup" data-toggle="modal" class="btn btn-xs btn-info"   data-original-title="Edit"><i class="fa fa-edit"></i></a>';

            $button_html .= '<a class="btn btn-xs btn-danger" onclick="mycontactgroup_data_delete(' . $mycontactgroup->id . ')"   href="#"><i class="fa fa-trash"></i></a>';
 
            $row[] = $button_html;
            $result[] = $row;
        }

        //return Datatables::of($result)->rawColumns([6])->make(true);
        return Datatables::of($result)->escapeColumns(['id'])->make(true);
    }

    /**
     * @Function name : getGroupContactsList
     * @Purpose :  MyContactGroups listing
     * @Added by : Sathish    
     * @Added Date : Jul 03, 2019
     */
    public function getGroupContactsList(Request $request)
    {
        $result = array();
        $whereArray = array('contact_group_map.contact_group_id' => $request->input('addContactsPopGroupId'));
         // dd($whereArray);
        $mycontactgroups = MyContactGroup::selectGroupContactsList($whereArray,null,null,null,null,null)->get();
        
        $i = 1;
        //check in total if any meeting available
        
        
        foreach ($mycontactgroups as $mycontactgroup) {
             
            $row = array();

            $row[] = $mycontactgroup->id;
            $row[] = $mycontactgroup->c_email;
            $row[] = $mycontactgroup->c_f_name;
            $row[] = $mycontactgroup->c_l_name;

            //showConfirm
            

            $button_html = '<a class="btn btn-xs btn-danger" onclick="group_contact_map_data_delete(' . $mycontactgroup->id . ')"   href="#"><i class="fa fa-trash"></i></a>';
 
            $row[] = $button_html;
            $result[] = $row;
        }

        //return Datatables::of($result)->rawColumns([6])->make(true);
        return Datatables::of($result)->escapeColumns(['id'])->make(true);
    }

    /**
     * @Function name : showAddContacts
     * @Purpose :  MyContactGroups listing
     * @Added by : Sathish    
     * @Added Date : Jul 03, 2019
     */
    public function showAddContacts($groupId)
    {
        $contactList="contact";
        $whereArray = array('contact_group_map.contact_group_id' => $groupId);
        //dd($whereArray);
        if($this->userguard->roles[0]->name == "superadmin"){
            $selectShowAddContactsList  = DB::select( DB::raw(" SELECT cl.id,cl.c_email,cl.c_f_name,cl.c_l_name FROM contact_list  cl WHERE  cl.id not in(select contact_group_map.contact_list_id from contact_group_map  where contact_group_map.contact_group_id='$groupId')") );
        }else{
            $selectShowAddContactsList  = DB::select( DB::raw(" SELECT cl.id,cl.c_email,cl.c_f_name,cl.c_l_name FROM contact_list  cl WHERE  cl.orgId = '".$this->userguard->orgId."' 
            and cl.id not in(select contact_group_map.contact_list_id from contact_group_map  where contact_group_map.contact_group_id='$groupId')") );
        }


        // dd($selectShowAddContactsList[0]->id);

        //MyContact::selectShowAddContactsList($whereArray,null,null,null,null,null)->get();
        // dd($selectShowAddContactsList);
        return view('settings.mycontactgroup.contact_list_add',compact('selectShowAddContactsList'));

    }

    /**
     * @Function name : addContactsToGroup
     * @Purpose :  MyContactGroups listing
     * @Added by : Sathish    
     * @Added Date : Jul 03, 2019
     */
    public function addContactsToGroup(Request $request)
    {
        $form_post = $request->all();

        $checkedValues = $form_post['contactadd_arr'];
        $contact_group_id = $form_post['pass_contact_group_id'];

        foreach($checkedValues as $value){
            $insertContact[] = array(
                'contact_list_id'=>$value,'contact_group_id'=>$contact_group_id
            );
        }
        $insertCGM = ContactGroupMap::insert($insertContact);
        return "success";

    }

    /**
     * @Function name : create
     * @Purpose :  MyContactGroups listing
     * @Added by : Sathish    
     * @Added Date : Jul 03, 2019
     */
    public function create(Request $request)
    {
         
    } 
    
    /**
     * @Function name : store
     * @Purpose :  MyContactGroups store
     * @Added by : Sathish    
     * @Added Date : Jul 03, 2019
     */
    
    public function store(Request $request)
    {
        $form_post = $request->all();
        $myContactGroupFormData = $request->except('hiddenMyContactGroupId');

        if($this->userguard->roles[0]->name == "superadmin"){
            $myContactGroupFormData['orgId'] = $this->userguard->orgId;
        }else{
            $myContactGroupFormData['orgId'] = $this->userguard->orgId;
        }

        $myContactGroupFormData['createdBy'] = $this->userguard->id;
        
        
        $insertDetails = MyContactGroup::create($myContactGroupFormData);
        if ($insertDetails->id > 0) {
            
            return json_encode(array("response"=>"success","message"=>'MyContactGroup created successfully.'));

        } else {
            return json_encode(array("response"=>"error","message"=>'Error in creating contact! Try again.....'));
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // return view('roles.show',compact('role','rolePermissions'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showGroup($id)
    {

        $contactList="contact";
        return view('settings.mycontactgroup.edit',compact('contactList'));

        return "customgroupiddata".$id;//$request->input('groupid');

        // return view('roles.show',compact('role','rolePermissions'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("contact_group_map")->where('contact_group_id',$id)->delete();
        DB::table("contact_group")->where('id',$id)->delete();

        return "success";
        return redirect()->route('mycontact.index')
        ->with('success','Contact deleted successfully');
    }

}