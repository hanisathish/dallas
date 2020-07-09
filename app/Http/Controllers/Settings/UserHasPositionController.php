<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Config;
use yajra\Datatables\Datatables;
use App\Helpers\CommunicationHelper;

use App\Models\Position;
use App\Models\UserHasPosition;
use App\Models\Events;
use App\Models\MasterLookupData;
use App\Models\SchedulingUser;
use App\Models\CommTemplate;
use App\User;

class UserHasPositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->userSessionData = Session::get('userSessionData');
        $this->orgId = $this->userSessionData['umOrgId'];
        $this->authUserId = $this->userSessionData['umId'];
    }

    public function userhaspositionIndex(){
        $data['title'] = $this->browserTitle . " - userhasposition List";
        return view('settings.userhasposition.index', $data);
    }

    public function getUserHasPositionList(){
        $result = array();
        $whereArray=array('orgId'=>$this->orgId);
        $userhaspositions = UserHasPosition::selectUserHasPositionDetail($whereArray,null,null,null,null,null)->get();
        
        $i = 1;
        foreach ($userhaspositions as $userhasposition) {
            $row = array();
            
            $row[] = $userhasposition->id;
            $row[] = $userhasposition->name;
            //showConfirm
            $button_html = '<a  onclick="edit_userhasposition('.$userhasposition->id.')"  data-toggle="tooltip"   href="#"  data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                <a onclick="userhasposition_data_delete('.$userhasposition->id.')"   href="#"><i class="fa fa-trash"></i></a>';
            
            $row[] = $button_html;
            $result[] = $row;
        }

        //return Datatables::of($result)->rawColumns([6])->make(true);
        return Datatables::of($result)->escapeColumns(['id'])->make(true);

    }

    /**
     * @Function name : getUserHasPositionById
     * @Purpose : Select from UserHasPosition by ID
     * @Added by : Sathish
     * @Added Date : Nov 07, 2018
     */
    public function getUserHasPositionById(Request $request) {
        $getUserHasPositionById = UserHasPosition::find($request->get('userhaspositionID'));
        return $getUserHasPositionById;
        
    }

    public function storeOrUpdateUserHasPosition(Request $request){
        $UserHasPositionFormData = $request->except('hidden_userhaspositionID');
        $UserHasPositionFormData['createdBy'] = $this->authUserId;
        $UserHasPositionFormData['orgId'] = $this->orgId;
        unset($UserHasPositionFormData['hidden_userhaspositionID'],$UserHasPositionFormData['_token']);
        if($request->get('hidden_userhaspositionID') > 0){
            unset($UserHasPositionFormData['createdBy']);
            $UserHasPositionFormData['updatedBy'] = $this->authUserId;
            $whereArray = array('id' => $request->get('hidden_userhaspositionID'));
            $updateDetails = UserHasPosition::updateUserHasPosition($UserHasPositionFormData,$whereArray);
            return "updated";            
        }else{
            $insertDetails = UserHasPosition::create($UserHasPositionFormData);
            if($insertDetails->id > 0){
                return "inserted";
            }else{
                return 0;
            }
        }
    }
 
    /**
     * @Function name : deleteUserHasPositionById
     * @Purpose : Delete from UserHasPosition
     * @Added by : Sathish
     * @Added Date : Nov 07, 2018
     */
    public function deleteUserHasPositionById(Request $request) {
        
        $whereArray=array('id'=>$request->get('userhaspositionId'));
        $updateAHDeletedStatus = array('deleted_at' => now(),'deletedBy' => $this->authUserId);  
        UserHasPosition::crudUserHasPosition($whereArray,null,null,null,null,$updateAHDeletedStatus,null,null);       
   }
}

