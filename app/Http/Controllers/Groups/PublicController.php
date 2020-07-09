<?php

namespace App\Http\Controllers\Groups;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Config;

use App\Models\Organization;
use App\Models\GroupType;
use App\Models\Group;
use App\Models\TagGroup;
use App\Models\GroupEvent;
use App\Models\GroupMember;

class PublicController extends Controller
{
    public function __construct()
    {
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
    }


    public function getGroupsListTemplate($orgDomain = null, $group_type = null){
        $org = Organization::where("orgDomain", $orgDomain)->first();
        if(isset($org)){
            $data['org'] = $org;
            if(isset($group_type)){
                $data['title'] = $this->browserTitle . " - ". $group_type . " Groups List";
                $data['gType'] = $group_type;
            }else {
                $data['title'] = $this->browserTitle . " - Groups List";
                $data['gType'] = "all";
            }
            
            $whereArray = array();
            			
            $data['group_types'] = GroupType::selectFromGroupType($whereArray,null,null,null,null,null,null,'1')->get();
            
   			
			if (\Request::route('orgDomain')) {
				
            $data['org'] = \Request::route('orgDomain');
        } else {
			
            $data['org'] =  \Request::segment(3);
        }	
		
	
            $data['get_all_group_types'] = GroupType::getallGroupTypesDetails()->get();

            //dd($data['get_all_group_types']); 
			
            return view("groups.public.groups_list", $data);            
        }else {
            abort(404, 'Organization not present.');
        }
    }

    public function getGroupsLists(Request $request){
        if($request["group_type"] == "all"){
            $resData["groupTypes"] = GroupType::where('orgId', $request['orgId'])
                                    ->select("id", 'name', 'description')
                                    ->withCount("groups")
                                    ->orderBy("name")->get();
            return $resData;
        }else{
            return $this->getGroupTypesListWithTagList($request['orgId']);
        }
    }

    static function getGroupTypesListWithTagList($orgId){
        $resData["groupTypes"] = GroupType::where('orgId', $orgId)
                                    ->select("id", 'name')->orderBy("name")->get();
        $resData["tagGroups"] = TagGroup::where("orgId", $orgId)->where("isPublic", 1)
                                    ->select("id", "name", "isMultiple_select")
                                    ->with(['tags' => function($query){
                                        $query->select("id", "name", "tagGroup_id")
                                                ->orderBy("order");
                                    }])->orderBy('order')->get();
        return $resData;
    }
	
	
	public function getAllGroups(Request $request) {
		
        $data['title'] = $this->browserTitle." - Groups List";
        
		
		if (\Request::route('orgDomain')) {
            $data['org'] = \Request::route('orgDomain');
        } else {
            $data['org'] = \Request::segment(3);
        }
		
		//dd($data['domain']);
		//dd($request->segment(4));
		
		$group_id = $request->segment(4);
		
        $whereArray = array('groups.groupType_id' => $group_id);	
		
	    $data['list_all_group_types'] = Group::selectFromGroup($whereArray,null,null,null,null,null,null,'1')->get();
	    //$data['list_all_group_types'] = Group::crudGroup($whereArray,null,null,null,null,'1')->get();
		
		//dd($data['list_all_group_types']);
        
        return view('groups.public.groups_list_all',$data);
    }


    public function getAllGroupsDetail(Request $request) {
		
        $data['title'] = $this->browserTitle." - Groups Event List";
        
		
		if (\Request::route('orgDomain')) {
            $data['org'] = \Request::route('orgDomain');
        } else {
            $data['org'] = \Request::segment(3);
        }
		
        $data['group_id'] = $request->segment(4);
		$group_id = $request->segment(4);
		
        $whereArray = array('group_events.group_id' => $group_id);
        
        //dd($group_id);
		        
	    $data['list_all_group_events'] = GroupEvent::crudGroupEvent($whereArray,null,null,null,null,null,null,'1')->get();
	    //dd($data['list_all_group_events']);

        $data['get_all_group_details'] = Group::getGroupTypesDetails($group_id);
        //dd($data['get_all_group_details']);  
                        
        
        return view('groups.public.groups_list_all_events',$data);
    }
	
    // Created By Santhosh 
    public function JoinGroupPage(Request $request) {

        $data['title'] = $this->browserTitle . " - Join Group";
        $data['orgID'] = $request->orgId;
        $data['groupid'] = $request->groupid;
       
    
        return view('groups.public.join_group', $data);

    }


    public function storeJoinGroupRequest(Request $request) {

        //dd($request);

        $insertData = $request->all();
        $insertData = $request->except(['_token']);
        $insertData['first_name'] = $request->full_name;
        $insertData['isUser'] = '2';
        //dd($insertData);

        GroupMember::create($insertData);

        return response()->json(
            [
                'success' => '1',
                "message" => '<div class="alert alert-success"> <strong>The group leader or the Groups administrator will get back to you as soon as they can. Thank you!</strong> </div>'
            ]
         );

    }	
	
	
}
