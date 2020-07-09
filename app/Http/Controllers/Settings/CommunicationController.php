<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Config;
use DataTables;
use App\Models\CommTemplate;

use App\User;
use App\Lookup;
use App\Models\UserMaster;
use App\Models\CommMaster;

class CommunicationController extends Controller
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
    public function getList(){
        $data['title'] = $this->browserTitle . " - Communication Management";

        return view('settings.communications', $data);
    }

    /**
    * Created By: Lokesh
    */
    public function getOrgTemplates($template_id = null){
        if(isset($template_id)){
            $templates = CommTemplate::where('org_id', $this->orgId)
                            ->where("id", $template_id)
                            ->select("id", "tag", "name", "subject", "body")->first();
        }else {
            $templates = CommTemplate::where('org_id', $this->orgId)
                            ->select("id", "tag", "name", "subject")->get();
        }
        
        return $templates;
    }

    /**
    * Created By: Lokesh
    */
    public function updateOrgTemplate(Request $request){
        $payload = json_decode(request()->getContent(), true);
        $template = CommTemplate::where("id", $payload["id"])
                            ->where("org_id", $this->orgId)->first();
        $template["body"] = $payload["body"];
        $template["name"] = $payload["name"];
        $template["subject"] = $payload["subject"];
        $template->save();

        $data = ["message"=> 'Communication Template has been created successfully'];
        return $data;
    }

    /**
     * Created By: Lokesh
     */
    public function userCommunicationsIndex($personal_id){
        $data['title'] = $this->browserTitle . " - Communication Management";
        $user = User::where('personal_id', $personal_id)->first();
        // $lookup = Lookup::where('mldId', $user['name_prefix'])->select('mldValue')->first();
        // $user['name_prefix'] = $lookup->mldValue;
        $data['user'] = $user;
        $data['isCommPage'] = true; 
        return view('members.communication.index', $data);
    }

    /**
    * Created By: Lokesh
    */
    public function getUserCommunications($personal_id){
        $result = array();
        // $user = User::where('personal_id', $personal_id)->with(['communications' => function($query){
        //                         $query->orderBy('subject', 'desc')->select("tag", "subject", "body", 'from_user_id')
        //                                 ->with(["createdUser" => function($query1){
        //                                     $query1->select("id", "full_name");
        //                                 }]);
        //                     }])->select("id", "orgId")->first();

        $user = User::where('personal_id', $personal_id)->first();

        $slNo = 1;
        foreach ($user->communications as $comm) {
            $row = array();
            $row[] = $slNo;
            $row[] = $comm->name;
            $row[] = $comm->subject;
            // $row[] = $comm->body;
            // $row[] = $comm->pivot["read_status"];
            // $row[] = $comm->pivot["delete_status"];
            $row[] = $comm->createdUser["full_name"];
            $row[] = \Carbon\Carbon::parse($comm->pivot["created_at"])->format('d-m-Y h:i');
            $row[] = "<button class='btn btn-outline-primary btn-xs' style='padding:0 5px;' onClick='openModalWithCommData(". $comm->id . ")'><i class='fa fa-eye'></i></button>"; 
            $result[] = $row;
            $slNo += 1;
        }

        return Datatables::of($result)->escapeColumns(['user_id'])->make(true);
    }    
    
    /**
    * Created By: Lokesh
    */
    public function getUserCommunication($personal_id, $master_id){
        $communication = CommMaster::where('id', $master_id)->with(["createdUser" => function($query){
                                        $query->select("id", "full_name", "email", "mobile_no");
                                    }])
                                    ->select("id", "type", "tag", "name", "subject", "body", "from_user_id")
                                    ->first();
        return $communication;
    }
}
