<?php

namespace App\Http\Controllers\Groups;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Config;

use App\Models\Organization;
use App\Models\GroupType;
use App\Models\TagGroup;

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
}
