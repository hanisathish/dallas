<?php

namespace App\Http\Controllers\Groups;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Config;

use App\Models\Tag;
use App\Models\TagGroup;
use App\Models\GroupTag;

class TagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->userSessionData = Session::get('userSessionData');
        $this->orgId = $this->userSessionData['umOrgId'];
    }

    /**
    * Created By: Lokesh
    */
    public function tagsIndex(){
        $data['title'] = $this->browserTitle . " - Group Tags List";
        
        return view('groups.tags', $data);
    }

    /**
    * Created By: Lokesh
    */
    public function getGroupsListWithTags(){
        $tagGroups = TagGroup::where("orgId", $this->orgId)->orderBy('order')->with(['tags' => function($query){
                        $query->orderBy('order')->select("id", "name", "tagGroup_id", "order");
                    }])->select("id", "name", "isPublic", "order", "isMultiple_select")->get();
        return $tagGroups;
    }

    /**
    * Created By: Lokesh
    */
    public function createOrUpdateTagGroup(Request $request){
        $payload = json_decode(request()->getContent(), true);
        $newTagGroup = null;
        if($payload["groupId"] == "create_new_node_id"){
            $newTagGroup = new TagGroup();
            $newTagGroup->order = $payload["order"];
            $newTagGroup->orgId = $this->orgId;
        }else {
            $newTagGroup = TagGroup::where("id", $payload["groupId"])->first();
        }
        $newTagGroup->name = $payload["name"];
        $newTagGroup->isPublic = $payload["isPublic"];
        $newTagGroup->isMultiple_select = $payload["isMultiple_select"];
        $newTagGroup->save();
        return ["id" => $newTagGroup->id];
    }

    /**
    * Created By: Lokesh
    */
    public function deleteTagGroup($tagGroup_id){
        TagGroup::where('id', $tagGroup_id)->delete();
        $tagIds = Tag::where("tagGroup_id", $tagGroup_id)->pluck('id');
        GroupTag::whereIn("tag_id", $tagIds)->delete();
        Tag::whereIn("id", $tagIds)->delete();

        return ["message" => "Tag Group has been successfully deleted"];

    }

    /**
    * Created By: Lokesh
    */
    public function createOrUpdateTag(Request $request){
        $payload = json_decode(request()->getContent(), true);
        $newTag = null;
        if($payload["id"] == "newTag"){
            $newTag = new Tag();
            $newTag->order = $payload["order"];
            $newTag->tagGroup_id = $payload["tagGroup_id"];
        }else {
            $newTag = Tag::where("id", $payload["id"])->first();
        }
        $newTag->name = $payload["name"];
        $newTag->save();

        return ["id" => $newTag->id];
    }

    /**
    * Created By: Lokesh
    */
    public function deleteTag($tag_id){
        GroupTag::where("tag_id", $tag_id)->delete();
        Tag::where("id", $tag_id)->delete();

        return ["message" => "Tag has been successfully deleted"];
    }

    /**
    * Created By: Lokesh
    */
    public function updateTagsOrder(Request $request){
        $payload = json_decode(request()->getContent(), true);
        $i = 1;
        foreach($payload as $tagId){
            $tag = Tag::where('id', $tagId)->first();
            $tag->order = $i;
            $tag->save();
            $i += 1;
        }
        return ["message" => "Tag Order has been successfully"];
    }

    /**
    * Created By: Lokesh
    */
    public function updateTagGroupsOrder(Request $request){
        $payload = json_decode(request()->getContent(), true);
        $i = 1;
        foreach($payload as $tagId){
            $tag = TagGroup::where('id', $tagId)->first();
            $tag->order = $i;
            $tag->save();
            $i += 1;
        }
        return ["message" => "Tag Groups Order has been successfully"];
    }
}