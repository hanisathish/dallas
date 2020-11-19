<?php

namespace App\Http\Controllers\Groups;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Config;
use Response;
use App\Models\Group;
use App\Models\GroupEvent;
use App\Models\GroupEventAttendance;
use App\Models\GroupMember;
use App\Models\GroupResource;
use App\Models\GroupType;
use App\Models\Location;
use App\Models\Insights;
use DB;
use DataTables;
use Auth;
use App\Helpers\CommunicationHelper;
use App\Models\CronBatchEmail;
use App\Models\CommTemplate;
use App\Models\UserMaster;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->userSessionData = Session::get('userSessionData');
        $this->orgId = $this->userSessionData['umOrgId'];
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->common_file_upload_path = Config::get('constants.FILE_UPLOAD_PATH');
        $this->common_file_download_path = Config::get('constants.FILE_DOWNLOAD_PATH');
    }

    public function groupsList(){
        $data['title'] = $this->browserTitle . " - Groups List";
        return view('groups.list', $data);
    }

    public function groupsListPagination(Request $request){
        $pageSize = $request->pageSize;
        $pageNumber = $request->pageNumber;
        $groupType = $request->groupType;
        $groupList = Group::getGroups($groupType)
                    ->orderBy("id","desc")
                    ->limit($pageSize)
                    ->offset($pageSize* ($pageNumber-1))
                    ->get();
        $count =DB::select('SELECT FOUND_ROWS() as record_count');
        $count = $count[0]->record_count;

        $items = array();
        
        foreach($groupList as $item) {
            $group_image = url('/assets/uploads/groupdefault.png');
            if($item->image_path != null) {
                $group_image_json = json_decode(unserialize($item->image_path));
                $group_image = $group_image_json->download_path . $group_image_json->uploaded_file_name;
            }
            

            //echo $item->last_meeting; exit();
            $html=' <div class="card m-b-5 border border-primary group p-0">
            <a href="'.url("groups/details/".$item->id).'" class="wrapper-link">

                            <div class="card-body p-0">

                            <div class="row no-gutters">


                                    <div class=" col-md-12 group-header" style=\'height: 116px;background-image:url('.$group_image.');\'>

                                      <div class="grouptype-name " ><h6 class="text-center">'.ucwords($item->name).'</h6></div>




                                    </div>



                             </div></div>

                             <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-6">Last Meeting</div>
                                    <div class="col-md-6">Next Meeting</div>
                                    <div class="col-md-6">'.(($item->last_meeting!=null)?$item->last_meeting:'None').'</div>
                                    <div class="col-md-6">'.(($item->next_meeting!=null)?$item->next_meeting:'None').'</div>
                                </div>
                            </div>
                            <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-12">Members</div>
                                <div class="col-md-12">'.$item->memberCount.'</div>

                            </div>
                        </div> </a>
                             </div>';
            $items[] = $html;
        }

        if(count($items) < 1) {
            $items[]=  "No Records";
        }

        return response()->json(
            [
                'success' => '1',
                "items" => $items,
                "count" =>$count
            ]
            );
    }


    public function groupDetails($id,$type = null) {
        $groupDetails =Group::getGroupDetails($id);
        $activeTab = "members";
        if($type!=""){
            $activeTab = $type;
        }

        if($type =="overview") {
            $data['overview'] =Group::getOverViewDetails($id,$groupDetails->groupType_id);
           // print_r($data['overview'] ); exit();
        }
        if($type =="attendance") {
            $formDate = date("Y-m-01");
            $toDate = date('Y-m-d');
            $data['attendance'] =GroupEvent::getMeetingDates($id,$formDate,$toDate);
           // print_r($data['overview'] ); exit();
        }
        $group_image = url('/assets/uploads/groupdefault.png');
        $data['activeTab'] =$activeTab;
        $data['groupId'] =$id;
        $data['title'] = $this->browserTitle . " - Group Details";
        $data['locations'] = Location::listLocations("")->get();
        $groupDetails->img = $group_image;

        if($groupDetails->image_path!=""){
            $r = json_decode(unserialize($groupDetails->image_path));

            $groupDetails->img =$r->download_path."/".$r->uploaded_file_name;
        }

        $data["groupDetails"] = $groupDetails;
        //return view('groups.group.group-details', $data);
        return view('groups.groups_details_view', $data);
    }

    public function membersList(Request $request){
        $groupId = $request->groupId;
        $members  =GroupMember::membersList($groupId,$request->search['value']);
        return DataTables::of($members)
                        ->addColumn('action', function($row) {

                            $btn = '<div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                              <a class="dropdown-item" href="javascript:removeMember('.$row->id.')">Remove from group</a>
                              <a class="dropdown-item" href="javascript:editMembershipDate('.$row->id.')">Edit Membership date</a>
                              <a class="dropdown-item" href="javascript:makeLeader('.$row->id.','.$row->grp_user_id.')">Make leader</a>
                            </div>
                          </div>';


                            return $btn;
                        })
                        ->addColumn('role', function($row) {
                            return ($row->role==2)?"Member":"Leader";
                        })

                        ->addColumn('member_since', function($row) {
                            return date('d-M-Y',strtotime($row->member_since));
                        })


                        ->rawColumns(['action',])
                        ->make(true);

        print_r($members->get());
    }

    public function addMembers(Request $request){

        $data['title'] = $this->browserTitle . " - Groups List";
        // $data['groupId'] = 1;
        return view('groups.group.add_members', $data);
    }

    public function getUsersList(Request $request) {
        $search = $request->phrase;
        $groupId = $request->groupId;
        //dd($search);exit();
        $usersList = Group::getUserListForAutocomplete($search,$groupId); //'id', 'first_name', 'last_name'
        $users = array();

        foreach ($usersList as $user) {
            $disabled = true;
            if($user->group_members_id == null || $user->group_members_id == "null"){
                $disabled = false;
            }
            $users[] = array("text"=>$user->first_name." ".$user->last_name,"id"=>$user->id,"disabled"=>$disabled);
        }
    //print_r($usersList);

    return response()->json(
                           $users
                    );
    }
    public function groupAddMember(Request $request) {
        $user_id = $request->selectedUser;
        $groupId = $request->groupId;

        if($user_id && $groupId > 0 && $groupId && $groupId > 0){
            $insertData['group_id'] = $groupId;
            $insertData['user_id'] = $user_id;
            $insertData['createdBy'] = Auth::id();
            $insertData['orgId'] = Auth::user()->orgId;

            GroupMember::create($insertData);

            return response()->json(
                [
                    'success' => '1',
                    "message" => '<div class="alert alert-success">
                                                         <strong>Saved!</strong>
                                                   </div>'
                ]
);

        }
    }

    public function memberAction(Request $request){
        $action = $request->action;
        $memberId = $request->memberId;
        $notify_member_role = $request->notify_member_role;
        // dd($notify_member_role);
        $grp_user_id = $request->grp_user_id;
        if($action =="remove") {
            $model = GroupMember::find( $memberId );
            $model->delete();
            $tag="notify_member_remove_from_group";
        }
        if($action =="update_date") {
            GroupMember::where("id", $memberId)
                        ->update(
                            [
                                "member_since"=>date("Y-m-d h:i:s",strtotime($request->member_since)),
                                "updatedBy"=> Auth::id()
                            ]
                        );
            
        }
        if($action =="make_leader") {
            GroupMember::where("id", $memberId)
                        ->update(
                            [
                                "role"=>1,
                                "updatedBy"=> Auth::id()
                            ]
                        );
            $tag="notify_member_make_leader";
        }

        //send notification and email on checkbox checked notify_member_role
        if($notify_member_role){
            if($grp_user_id != 0){

                CommunicationHelper::generateCommunications($tag, Auth::user()->orgId, '2', Auth::user()->id, array($grp_user_id), null, null);

                 
            }else{
                       
                $template = CommTemplate::where('tag', $tag)->where('org_id', Auth::user()->orgId)->first();
                if(empty($template)){
                    $template = (new static)->addCommTemplateToOrg($tag, Auth::user()->orgId);
                }       
                $getGroupMember = GroupMember::find( $memberId );
                    // dd($getGroupMember);
                    $cronInsertArray = array(
                        'recipient_user_id' => null,
                        'orgId' => Auth::user()->orgId,
                        'subject' => $template->subject,
                        'message' => $template->body,
                        'recipient' => $getGroupMember->email,
                        // 'cc_recipient' => $cronCcEmails,
                        'files_offset' => null,
                        'file_attach' => null,
                        'send_status' => 0,
                        'sent_from' => env('MAIL_FROM_NAME'),
                        'sent_from_email' => env('MAIL_FROM_ADDRESS'),
                        'send_dts' => date("Y-m-d H:i:s"),
                        'mail_error' => '',
                        'createdBy'=>Auth::user()->id
                        // 'subaccount_id' => $email_subaccount_id
                    );
                    
                
                    CronBatchEmail::insert($cronInsertArray); 
            }
            
        }
    }

    /**
     * Creating a New communication template, If Template not created for respective org
     */
    public static function addCommTemplateToOrg($tag, $orgId){
        $template = CommTemplate::where('tag', $tag)->where('org_id', 0)->first();
        $newTemplate = CommTemplate::create([
                            'tag' => $template->tag,
                            'name' => $template->name,
                            'subject' => $template->subject,
                            'body' => $template->body,
                            'org_id' => $orgId
                        ]);
        return $newTemplate;
    }
    /*** events */

    public function addEvents(Request $request){

        $data['title'] = $this->browserTitle . " - ";
        $data['groupId'] = $request->groupId;
        $data['locations'] = Location::listLocations("")->get();
        return view('groups.group.add_events', $data);
    }

    public function groupAddEvents(Request $request){
        $insertData = $request->all();

        $eventId = $request->eventId;

        //validation rules




        $insertData = $request->except(['_token', 'eventId',]);
        $insertData["isMutiDay_event"] = 0;
        if($request->isMutiDay_event){
            $insertData["isMutiDay_event"] = 1;
        }

        if ($eventId > 0) { //update
            $insertData['updatedBy'] = Auth::id();


            GroupEvent::where("id", $eventId)->update($insertData);
        } else { //insert
            $insertData['createdBy'] = Auth::id();
            $insertData['orgId'] = Auth::user()->orgId;

            GroupEvent::create($insertData);
        }

        return response()->json(
                        [
                            'success' => '1',
                            "message" => '<div class="alert alert-success">
                                                                 <strong>Saved!</strong>
                                                           </div>'
                        ]
        );
    }

    public function eventsList(Request $request) {
        $groupId = $request->groupId;
        $members  =GroupEvent::eventsList($groupId,$request->search['value']);
        return DataTables::of($members)
                        ->addColumn('action', function($row) {

                            $btn = '<a onclick="editEvent(' . $row->id . ')"  class="edit btn btn-primary btn-sm ">Edit</a>';

                            $start_time  = $row->start_date." ".$row->start_time;
                            $end_time  = $row->end_date." ".$row->end_time;

                            $current = time();

                            $before = Config::get('constants.ATTEDENCE_LOCK.BEFORE');
                            $after  = Config::get('constants.ATTEDENCE_LOCK.AFTER');

                            $startDate = date("Y-m-d H:i:s",strtotime($start_time)-$before*60);
                            //echo date("Y-m-d h:i:s",time()). " ".$startDate. "---- ";
                            //echo date_default_timezone_get();
                         // echo $startDate . " ".strtotime($startDate)."<br/>";
                            $disbled ="disabled";
                            $title= "Diabled";
                            if(  $current >= strtotime($startDate) ) {
                                //echo "here";
                                $endDate = date("Y-m-d H:i:s",strtotime($end_time)+($after*60));
                                //echo $current." -- ".($endDate); exit();
                                if($current <= strtotime($endDate)  ){
                                    //echo "here";
                                    $disbled = "";
                                    $title= "";
                                }
                            }
                            //echo $start_time. " --". $startDate;


                            $btn.= '<a onclick="markAttedence(' . $row->id . ')" title="'.$title.'" class="edit btn btn-primary btn-sm mx-md-1 '.$disbled.'" '.$disbled.'>Attendence</a>';

                            return $btn;
                        })
                        ->addColumn('start', function($row) {
                            return date('d-M-Y',strtotime($row->start_date))." ".$row->start_time;
                        })

                        ->addColumn('end', function($row) {
                            return date('d-M-Y',strtotime($row->end_date))." ".$row->end_time;
                        })


                        ->rawColumns(['action',])
                        ->make(true);
    }

    public function editEvent($eventId, Request $request){
        $data['title'] = $this->browserTitle . " - ";
        $data['groupId'] = $request->groupId;
        $data['event'] = GroupEvent::find($eventId);
        $data['locations'] = Location::listLocations("")->get();
        return view('groups.group.add_events', $data);
    }

    /** end */
    /** Resource */



    public function addResources(Request $request){

        $data['title'] = $this->browserTitle . " - ";
        $data['groupId'] = $request->groupId;
        return view('groups.group.add_resource', $data);
    }
	
	

    public function groupAddResources(Request $request){
        //$insertData = $request->all();

        $resourceId = $request->resourceId;

        //validation rules

        $file = "";
        if (isset($request->file) && $request->file != "") {
            $file = $this->resourceFileUpload($request->file,$request->group_id);
        }
        $insertData = $request->except(['_token', 'resourceId',"file","source",'url_name','url_description','url_visibility']);
        //print_r($insertData);
        if($request->type==2){
            $insertData['name'] = $request->url_name;
            $file = $request->source;
            $insertData['description'] =  $request->url_description;
            $insertData['visibility'] = $request->url_visibility;
        }

        //
        //print_r($insertData);
        if ($file == "") {
            //$insertData->except(['item_photo']);
        } else {
            $insertData['source'] = $file;
        }

        if ($resourceId > 0) { //update
            $insertData['updatedBy'] = Auth::id();


            GroupResource::where("id", $resourceId)->update($insertData);
        } else { //insert
            $insertData['createdBy'] = Auth::id();
            $insertData['orgId'] = Auth::user()->orgId;

            GroupResource::create($insertData);
        }

        return response()->json(
                        [
                            'success' => '1',
                            "message" => '<div class="alert alert-success">
                                                                 <strong>Saved!</strong>
                                                           </div>'
                        ]
        );
    }
	

    public function resourcesList(Request $request) {
        $groupId = $request->groupId;
        $members  =GroupResource::resourceList($groupId,$request->search['value']);
        return DataTables::of($members)
                        ->addColumn('action', function($row) {

                            $btn ="";

                            if($row->type==1) {
                                $r = json_decode(unserialize($row->source));

                                $url =$r->download_path."/".$r->uploaded_file_name;
                                //$r->uploaded_file_name;

                                $btn.='<a download href="'.$url.'" class="btn btn-outline-primary btn-sm" target="_blank">Download</a>';
                            }
                            else {
                                $btn.='<a href="'.$row->source.'" class="btn btn-outline-primary btn-sm" target="_blank">Go to Link</a>';
                            }

                            $btn.= '<a onclick="editResource(' . $row->id . ')"  class="edit btn btn-primary btn-sm float-right"><i class="fa fa-edit"></i></a>';



                            return $btn;
                        })

                        ->addColumn('type', function($row) {
                            return ($row->type==1)?'<i title="file" class="fa fa-file" aria-hidden="true"></i>':'<i title="link" class="fa fa-link" aria-hidden="true"></i>';
                        })

                        ->addColumn('updated_at', function($row) {
                            return date('d-M-Y',strtotime($row->updated_at));
                        })

                        ->addColumn('visibility', function($row) {
                            return ($row->visibility==1)?'Leaders/Admins':'All';
                        })
                        ->rawColumns(['action',"type"])
                        ->make(true);
    }

    public function editResources($eventId, Request $request){
        $data['title'] = $this->browserTitle . " - ";
        $data['groupId'] = $request->groupId;
        $data['resource'] = GroupResource::find($eventId);



        if($data['resource'] != null){
            //echo $data['resource']->source; exit();
            if($data['resource']->type==1){
                $r = json_decode(unserialize($data['resource']->source));
                $data['resource']->source = $r->uploaded_file_name;
            }
            else {

            }



        }

        return view('groups.group.add_resource', $data);
    }


    /**  Insights **/

    public function addInsights(Request $request){

        $data['title'] = $this->browserTitle . " - ";
        $data['groupId'] = $request->groupId;
        return view('groups.group.add_insights', $data);
    }
	
	
	public function groupAddInsights(Request $request){
		
        //$insertData = $request->all();

 		
        $resourceId = $request->resourceId;

        //validation rules

        $file = "";
        if (isset($request->file) && $request->file != "") {
            $file = $this->insightsFileUpload($request->file,$request->group_id);
        }
        $insertData = $request->except(['_token', 'resourceId',"file","source",'url_name','url_description','url_visibility']);
        //print_r($insertData);
        // if($request->type==2){
            
        // }

        //
        //print_r($insertData);
        if ($file == "") {
            // $insertData['source'] = $file;
            $insertData['name'] = $request->url_name;
            // $file = $request->source;
            $insertData['description'] =  $request->url_description;
            $insertData['visibility'] = $request->url_visibility;
            $insertData['type'] = 2;
        } else {
            $insertData['source'] = $file;
            // $insertData['name'] = $request->url_name;
            // $file = $request->source;
            // $insertData['description'] =  $request->url_description;
            // $insertData['visibility'] = $request->url_visibility;
            $insertData['type'] = 1;
        }

        if ($resourceId > 0) { //update
            $insertData['updatedBy'] = Auth::id();


            Insights::where("id", $resourceId)->update($insertData);
        } else { //insert
            $insertData['createdBy'] = Auth::id();
            $insertData['orgId'] = Auth::user()->orgId;

            Insights::create($insertData);
        }

        return response()->json(
                        [
                            'success' => '1',
                            "message" => '<div class="alert alert-success"><strong>Saved!</strong></div>'
                        ]
        );
    }
	
	
	public function insightList(Request $request) {
        $groupId = $request->groupId;
        $members  = Insights::insightList($groupId,$request->search['value']);
        return DataTables::of($members)
                        ->addColumn('action', function($row) {

                            $btn ="";

                            if($row->type==1) {
                                $r = json_decode(unserialize($row->source));

                                $url =$r->download_path."/".$r->uploaded_file_name;
                                //$r->uploaded_file_name;

                                $btn.='<a download href="'.$url.'" class="btn btn-outline-primary btn-sm" target="_blank">Download</a>';
                            }
                            else {
                                $btn.='<a href="'.$row->source.'" class="btn btn-outline-primary btn-sm" target="_blank">Go to Link</a>';
                            }

                            $btn.= '<a onclick="editInsights(' . $row->id . ')"  class="edit btn btn-primary btn-sm float-right"><i class="fa fa-edit"></i></a>';



                            return $btn;
                        })

                        ->addColumn('type', function($row) {
                            return ($row->type==1)?'<i title="file" class="fa fa-file" aria-hidden="true"></i>':'<i title="link" class="fa fa-link" aria-hidden="true"></i>';
                        })

                        ->addColumn('updated_at', function($row) {
                            return date('d-M-Y',strtotime($row->updated_at));
                        })

                        ->addColumn('visibility', function($row) {
                            return ($row->visibility==1)?'Leaders/Admins':'All';
                        })
                        ->rawColumns(['action',"type"])
                        ->make(true);
    }
	
	
	
	public function editInsights($eventId, Request $request){
        $data['title'] = $this->browserTitle . " - ";
        $data['groupId'] = $request->groupId;
        $data['resource'] = Insights::find($eventId);


        if($data['resource'] != null){
            //echo $data['resource']->source; exit();
            if($data['resource']->type==1){
                $r = json_decode(unserialize($data['resource']->source));
                $data['resource']->source = $r->uploaded_file_name;
            }
            else {

            }
        }

        return view('groups.group.add_insights', $data);
    }
	



	

    public function groupStoreSettings(Request $request){
        //$insertData = $request->all();


        $insertData = $request->except(['_token', 'groupId',]);


        if ($request->groupId > 0) { //update
            $insertData['updatedBy'] = Auth::id();

            $visible_leaders_fields = "";
            if($request->visible_leaders_fields) {
                $visible_leaders_fields =  json_encode($request->visible_leaders_fields);

            }
            $insertData['visible_leaders_fields'] = $visible_leaders_fields;

            $visible_members_fields = "";
            if($request->visible_members_fields) {
                $visible_members_fields =  json_encode($request->visible_members_fields);

            }
            $insertData['visible_members_fields'] = $visible_members_fields;

            $insertData['enroll_autoClose_on'] =NULL;
            $insertData['enroll_autoClose_count'] =NULL;
            $insertData['enroll_notify_count'] =NULL;


            if($request->is_enroll_autoClose){
                $insertData['enroll_autoClose_on'] =date("Y-m-d",strtotime($request->enroll_autoClose_on));
            }
            else {
                $insertData['is_enroll_autoClose'] = 0;
            }
            if($request->is_enroll_autoClose_count){
                $insertData['enroll_autoClose_count'] =$request->enroll_autoClose_count;
            }
            else {
                $insertData['is_enroll_autoClose_count'] = 0;
            }
            if($request->is_enroll_notify_count){
                $insertData['enroll_notify_count'] =$request->enroll_notify_count;
            }
            else {
                $insertData['is_enroll_notify_count'] = 0;
            }

            Group::where("id", $request->groupId)->update($insertData);

        }

        return response()->json(
                        [
                            'success' => '1',
                            "message" => '<div class="alert alert-success">
                                                                 <strong>Saved!</strong>
                                                           </div>'
                        ]
        );
    }

    public function groupStoreImage(Request $request){
        $im = "group-image";
        if (isset($request->$im) && $request->$im != "") {
            $file = $this->groupImageFileUpload($request->$im,$request->groupId);

            $insertData['image_path'] = $file;
            $insertData['updatedBy'] = Auth::id();


            Group::where("id", $request->groupId)->update($insertData);

            $r = json_decode(unserialize($file));

            return response()->json(
                [
                    'success' => '1',
                    "image" =>$r->download_path."/".$r->original_filename
                ]);
            print_r($r);


        }
    }


    public function attedenceList(Request $request){
        $groupId = $request->groupId;
        $events = $request->events;
        $eventsObj = json_decode($events);
        $members  =GroupMember::membersList($groupId,$request->search['value']);
        $datatable =   DataTables::of($members);

        $raw =array();

        //print_r($eventsObj);


                        if($eventsObj) {
                        foreach($eventsObj as $value){

                            $datatable = $datatable->addColumn(str_replace(" ","_",$value->event_date), function($row)use($value,$raw) {


                                $exists = GroupEventAttendance::select("id as exists")
                                            ->where("event_id",$value->id)
                                            ->where("group_member_id",$row->id)
                                            ->first();
                                $html = '<i class="fa fa-check-circle  att-icon text-success" aria-hidden="true"></i>';

                                if(!$exists){
                                    if(!isset( $GLOBALS['attedence'][$row->id])) {
                                        $GLOBALS['attedence'][$row->id] = 0;
                                    }
                                    $GLOBALS['attedence'][$row->id] ++;
                                    $html = '<i class="fa fa-times-circle att-icon text-warning" aria-hidden="true"></i>';
                                }
                                //print_r($raw);
                                return $html;


                            });
                        }
                    }
                    $datatable = $datatable->addColumn('percentage', function($row)use($eventsObj) {
                        $per = 100;
                        if(count($eventsObj) > 0){
                            $active =count($eventsObj)-$GLOBALS['attedence'][$row->id];

                            $per = round(($active*100)/count($eventsObj));

                        }
                        return $per."%";//$GLOBALS['attedence'];
                    });

                    if($eventsObj) {
                        foreach($eventsObj as $value){
                            $raw[] =str_replace(" ","_",$value->event_date);
                        }
                    }
                        //print_r($raw);
                        $datatable = $datatable->rawColumns(array_values($raw));
                         return $datatable->make(true);

        print_r($members->get());
    }

    public function getEventDates(Request $request){
        $start_date = date("Y-m-d",strtotime($request->start_date));
        $end_date = date("Y-m-d",strtotime($request->end_date));
        $id = $request->group_id;

        $events = GroupEvent::getMeetingDates($id,$start_date,$end_date);

        return response()->json(
            [
                'events' => $events
            ]);

    }

    public function markAttendence($eventId,Request $request) {
        $data['title'] = $this->browserTitle . " - ";
        $data['groupId'] = $request->groupId;
        $data['eventId'] = $eventId;

        $members  =GroupMember::membersListForAttdedence($request->groupId,$eventId)->get();
        //print_r($members);
        $data['members'] = $members;
        return view('groups.group.log-attedence', $data);
    }

    public function submitAttendence(Request $request) {

        $eventId =$request->event_id;
        GroupEventAttendance::where("event_id",$eventId)->delete();
        $insert = array();
        foreach($request->attedence as $attedence) {
            $insert[] = ["event_id"=>$eventId,"group_member_id"=>$attedence,"createdBy"=>Auth::id()];
        }
        GroupEventAttendance::insert($insert);

        return response()->json(
            [
                'success' => 1
            ]);
    }

    public function groupCreateForm(Request $request){
        $data = [];
        $data['groupTypes'] = GroupType::getGroupTypesList("")->get();
        return view('groups.add-group', $data);
    }

    public function groupStore(Request $request){
        //print_r($request->all());
        $groupType =$request->add_group_type;
        $groupName = $request->add_group_name;

        $groupTypeDetails = GroupType::find($groupType);

        $insertData = [
            "orgId" => Auth::user()->orgId,
            "groupType_id" =>$groupType,
            "name" => trim($groupName),
            "is_enroll_autoClose" =>$groupTypeDetails->d_is_enroll_autoClose,
            "enroll_autoClose_on" =>$groupTypeDetails->d_enroll_autoClose_on,
            "is_enroll_autoClose_count"=>$groupTypeDetails->d_is_enroll_autoClose_count,
            "enroll_autoClose_count"=>$groupTypeDetails->d_enroll_autoClose_count,
            "is_enroll_notify_count"=>$groupTypeDetails->d_is_enroll_notify_count,
            "enroll_notify_count"=>$groupTypeDetails->d_enroll_notify_count,
            "contact_email"=>$groupTypeDetails->d_contact_email,
            "visible_leaders_fields"=>$groupTypeDetails->d_visible_leaders_fields,
            "visible_members_fields"=>$groupTypeDetails->d_visible_members_fields,
            "can_leaders_search_people"=>$groupTypeDetails->d_can_leaders_search_people,
            "can_leaders_take_attendance"=>$groupTypeDetails->d_can_leaders_take_attendance,
            "event_remind_before" => $groupTypeDetails->d_event_remind_before,
            "is_event_remind"=>$groupTypeDetails->d_is_event_remind,
            "enroll_status"=>$groupTypeDetails->d_enroll_status,
            "enroll_msg"=>$groupTypeDetails->d_enroll_msg,
            "leader_visibility_publicly"=>$groupTypeDetails->d_leader_visibility_publicly,
            "is_event_public"=>$groupTypeDetails->d_is_event_public,
            'createdBy' => Auth::id()
        ];
        Group::insert($insertData);
        //print_r($insertData);

    }
    private function resourceFileUpload($file,$groupId) {


        $extension = $file->getClientOriginalExtension();


        $imageName = basename($file->getClientOriginalName(), ("." . $extension));

        $imageName .= "_" . time() . '.' . $extension;
        $destinationPath = $this->common_file_upload_path['PROFILE_PIC_UPLOAD_PATH'] . DIRECTORY_SEPARATOR . Auth::user()->orgId . DIRECTORY_SEPARATOR . "group" .DIRECTORY_SEPARATOR .$groupId. DIRECTORY_SEPARATOR . "resource". DIRECTORY_SEPARATOR;


        $downloadPath = $this->common_file_download_path['PROFILE_PIC_DOWNLOAD_PATH'] . '/' . Auth::user()->orgId . '/' . "group/$groupId/resource" . '/';


        $file->move(
                $destinationPath, $imageName
        );



        $upload_data = array('uploaded_path' => $destinationPath, 'download_path' => $downloadPath, 'uploaded_file_name' => $imageName, 'original_filename' => $imageName, 'upload_file_extension' => $extension, 'file_size' => 0);
        $jsonformat = serialize(json_encode($upload_data));

        return $jsonformat;
    }
	
	
	private function insightsFileUpload($file,$groupId) {


        $extension = $file->getClientOriginalExtension();


        $imageName = basename($file->getClientOriginalName(), ("." . $extension));

        $imageName .= "_" . time() . '.' . $extension;
        $destinationPath = $this->common_file_upload_path['PROFILE_PIC_UPLOAD_PATH'] . DIRECTORY_SEPARATOR . Auth::user()->orgId . DIRECTORY_SEPARATOR . "group" .DIRECTORY_SEPARATOR .$groupId. DIRECTORY_SEPARATOR . "insights". DIRECTORY_SEPARATOR;


        $downloadPath = $this->common_file_download_path['PROFILE_PIC_DOWNLOAD_PATH'] . '/' . Auth::user()->orgId . '/' . "group/$groupId/insights" . '/';


        $file->move(
                $destinationPath, $imageName
        );



        $upload_data = array('uploaded_path' => $destinationPath, 'download_path' => $downloadPath, 'uploaded_file_name' => $imageName, 'original_filename' => $imageName, 'upload_file_extension' => $extension, 'file_size' => 0);
        $jsonformat = serialize(json_encode($upload_data));

        return $jsonformat;
    }
	
	


    private function groupImageFileUpload($file,$groupId) {


        $extension = $file->getClientOriginalExtension();


        $imageName = basename($file->getClientOriginalName(), ("." . $extension));

        $imageName .= "_" . time() . '.' . $extension;
        $destinationPath = $this->common_file_upload_path['PROFILE_PIC_UPLOAD_PATH'] . DIRECTORY_SEPARATOR . Auth::user()->orgId . DIRECTORY_SEPARATOR . "group" .DIRECTORY_SEPARATOR .$groupId. DIRECTORY_SEPARATOR;


        $downloadPath = $this->common_file_download_path['PROFILE_PIC_DOWNLOAD_PATH'] . '/' . Auth::user()->orgId . '/' . "group/$groupId" . '/';


        $file->move(
                $destinationPath, $imageName
        );



        $upload_data = array('uploaded_path' => $destinationPath, 'download_path' => $downloadPath, 'uploaded_file_name' => $imageName, 'original_filename' => $imageName, 'upload_file_extension' => $extension, 'file_size' => 0);
        $jsonformat = serialize(json_encode($upload_data));

        return $jsonformat;
    }

    /** end */
}
