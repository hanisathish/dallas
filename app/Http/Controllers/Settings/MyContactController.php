<?php
namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Config;

use DataTables; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\MyContact;
use App\Models\MyContactGroup;
use App\Models\ContactGroupMap;
use Illuminate\Http\Response;

class MyContactController extends Controller
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
     * @Purpose :  MyContacts listing
     * @Added by : Sathish    
     * @Added Date : Jul 03, 2019
     */
    public function index(Request $request)
    {
        $data['title'] = "MyContact";
        
        // dd($data);
        //return view('import_excel', compact('data'));
        return view('settings.mycontact.index',$data);
    }

    /**
     * @Function name : listMyContact
     * @Purpose :  MyContacts listing
     * @Added by : Sathish    
     * @Added Date : Jul 03, 2019
     */
    public function getMyContactList()
    {
        $result = array();
        if($this->userguard->roles[0]->name == "superadmin"){
            $whereArray = null;
        }else{
            $whereArray = array('contact_list.createdBy' => $this->userguard->id);    
        }
        

        $dataObj['groupBy'] = array('contact_list.id');
        $dataObj['orderBy'] = array('contact_list.c_f_name'=>'asc');

        $mycontacts = MyContact::selectMyContactDetail($whereArray,null,null,null,null,$dataObj)->get();
        
        $i = 1;
        //check in total if any meeting available
        
        
        foreach ($mycontacts as $mycontact) {
             
            $row = array();

            $row[] = $mycontact->id;
            $row[] = $mycontact->c_email;
            $row[] = $mycontact->c_f_name;
            $row[] = $mycontact->c_l_name;
            $row[] = $mycontact->group_name;
            //showConfirm
            $button_html = '<a class="btn btn-xs btn-info" data-toggle="tooltip"   href="mycontact/'.$mycontact->id.'/edit"  data-original-title="Edit"><i class="fa fa-edit"></i></a>';

            $button_html .= '<a class="btn btn-xs btn-danger" onclick="mycontact_data_delete(' . $mycontact->id . ')"   href="#"><i class="fa fa-trash"></i></a>';
 
            $row[] = $button_html;
            $result[] = $row;
        }

        //return Datatables::of($result)->rawColumns([6])->make(true);
        return Datatables::of($result)->escapeColumns(['id'])->make(true);
    }
    /**
     * @Function name : create
     * @Purpose :  MyContacts listing
     * @Added by : Sathish    
     * @Added Date : Jul 03, 2019
     */
    public function create(Request $request)
    {
        $data['title'] = "Create MyContact";
        if($this->userguard->roles[0]->name == "superadmin"){
            $whereArray = null;
        }else{
            $whereArray = array('contact_group.createdBy' => $this->userguard->id);    
        }
        $data['crudMyContactGroup'] = MyContactGroup::crudMyContactGroup($whereArray,null,null,null,null,null,null,'1')->get();
        
        $data['selectFromContactGroupMap'] = null;//array("");
        //dd($data['selectFromContactGroupMap']);
        return view('settings.mycontact.create',$data);
    } 
    
    /**
     * @Function name : store
     * @Purpose :  MyContacts store
     * @Added by : Sathish    
     * @Added Date : Jul 03, 2019
     */
    
    public function store(Request $request)
    {
        $form_post = $request->all();
        //dd($request->input('group_id'));
        $myContactFormData = $request->except('hiddenMyContactId');

        $myContactFormData['createdBy'] = $this->userguard->id;
        
        
        if($this->userguard->roles[0]->name == "superadmin"){
            $myContactFormData['orgId'] = $this->userguard->id;
        }else{
            $myContactFormData['orgId'] = $this->userguard->id;
        }
        $insertDetails = MyContact::create($myContactFormData);
        if ($insertDetails->id > 0) {
            
            //insert into group map
            if($request->input('group_id')){
                $checkedValues = $request->input('group_id');
                $contact_list_id = $insertDetails->id;

                foreach($checkedValues as $value){
                    $insertGroupToContact[] = array(
                        'contact_list_id'=>$contact_list_id,'contact_group_id'=>$value
                    );
                }
                $insertCGM = ContactGroupMap::insert($insertGroupToContact);
            }
            //return redirect ('/mycontact');
            return redirect()->route('mycontact.index')
                        ->with('success','Contact created successfully.');
            // return json_encode(array("response"=>"success","message"=>'MyContact created successfully.'));

        } else {
            return redirect ('/mycontact/create');
            // return json_encode(array("response"=>"error","message"=>'Error in creating contact! Try again.....'));
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
        $mycontact = MyContact::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
        ->where("role_has_permissions.role_id",$id)
        ->get();


        return view('settings.mycontact.create',compact('mycontact','rolePermissions'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit MyContact";

        $mycontact = MyContact::find($id);
        
        $crudMyContactGroup = MyContactGroup::crudMyContactGroup(null,null,null,null,null,null,null,'1')->get();

        $selectFromContactGroupMap = ContactGroupMap::selectFromContactGroupMap(array('contact_list_id'=>$id))->get();
        // dd(array_column($selectFromContactGroupMap->toArray(),'id'));
        // dd($selectFromContactGroupMap->toArray());

        return view('settings.mycontact.create',compact('title','mycontact','crudMyContactGroup','selectFromContactGroupMap'));
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
        
        $mycontact = MyContact::find($id);
        $mycontact->c_email = $request->input('c_email');
        $mycontact->c_f_name = $request->input('c_f_name');
        $mycontact->c_l_name = $request->input('c_l_name');
        $mycontact->save();

        //delete ContactGroupMap::
        ContactGroupMap::deleteContactGroupMap(array('contact_list_id'=>$id));

        if(count($request->input('group_id')) > 0) {
            foreach ($request->input('group_id') as $value) {
                
                $arrayUpdate = array(
                    'contact_list_id'=>$id,
                    'contact_group_id'=>$value
                );

                ContactGroupMap::updateOrCreate(array('contact_list_id' => $id, 'contact_group_id' => $value), $arrayUpdate);
            }
        }
       // dd($arrayUpdate);

        
        


        return redirect()->route('mycontact.index')
        ->with('success','Contact updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("contact_group_map")->where('contact_list_id',$id)->delete();
        DB::table("contact_list")->where('id',$id)->delete();

        return "success";
        return redirect()->route('mycontact.index')
        ->with('success','Contact deleted successfully');
    }

    /**
     * @Function name : getMeetingParticipants
     * @Purpose :  meeting participants listing
     * @Added by : Sathish    
     * @Added Date : Jul 03, 2019
     */
    public function getMeetingParticipants(Request $request)
    {
        // dd($request->meeting_id);
        $result = array();
         
        $whereArray = array('meeting_participants.meeting_id' => $request->meeting_id);

        // $dataObj['groupBy'] = array('meeting_participants.id');
        // $dataObj['orderBy'] = array('meeting_participants.c_f_name'=>'asc');

        $meetingParticipants = MeetingParticipants::crudMeetingParticipants($whereArray,null,null,null,null,null,null,'1')->get();
        // dd($meetingParticipants);

        $i = 1;
        //check in total if any meeting available
        
        
        foreach ($meetingParticipants as $meetPart) {
             
            $row = array();

            $row[] = $meetPart->id;
            $row[] = $meetPart->p_email;
            $row[] = $meetPart->p_f_name;
            $row[] = $meetPart->p_l_name;
            $row[] = $meetPart->user_role;
            //showConfirm
            $button_html = '';
            
            
            $row[] = $button_html;
            $result[] = $row;
        }

        //return Datatables::of($result)->rawColumns([6])->make(true);
        return Datatables::of($result)->escapeColumns(['id'])->make(true);
    }

}