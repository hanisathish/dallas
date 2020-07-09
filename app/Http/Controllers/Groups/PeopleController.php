<?php

namespace App\Http\Controllers\Groups;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Config;
use App\Models\UserMaster;
use DataTables;

class PeopleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->userSessionData = Session::get('userSessionData');
        $this->orgId = $this->userSessionData['umOrgId'];
    }

    public function peopleIndex(){
        $data['title'] = $this->browserTitle . " - Peoples List";
        
        return view('groups.people', $data);
    }

    /**
     * @Function name : peopleList
     * @Purpose : To fetch peopleList
     * @Added by : Sathish
     * @Added Date : Nov 05, 2018
     */
    public function peopleList(Request $request) {
        $result = array();
        $data = array();
        $whereArray = array('users.orgId' => $this->userSessionData['umOrgId']);
        $whereNotInArray = null;
        if ($request->admindatatable == 1) {
            $whereArray = array('role_tag' => $request->role_tag, 'users.orgId' => $this->userSessionData['umOrgId']);
        } else {
            //$whereNotInArray = array('role_tag' => array('admin'));
        }

        //dd($whereArray,$whereNotInArray);
        $selectUserMasterDetail = UserMaster::selectUserMasterDetail($whereArray, null, $whereNotInArray, null, null, null)->get();
        $profile_edit_link = '';
        foreach ($selectUserMasterDetail as $selectUserMasterDetailData) {
            $row = array();

            $profile_edit_link = url("/") . '/people/member/' . $selectUserMasterDetailData->personal_id;

            //$row[] = $selectUserMasterDetailData->user_id;
            $profile_pic_image = url('/assets/uploads/organizations/avatar.png');
            if ($selectUserMasterDetailData->profile_pic != null) {
                $profile_pic_image_json = json_decode(unserialize($selectUserMasterDetailData->profile_pic));
                $profile_pic_image = $profile_pic_image_json->download_path . $profile_pic_image_json->uploaded_file_name;
            }
            $row[] = '<img class="d-flex mr-3 rounded-circle" src="' . $profile_pic_image . '" alt="Generic placeholder image" height="64">';
            $row[] = '<a href="' . $profile_edit_link . '">' . $selectUserMasterDetailData->first_name . " " . $selectUserMasterDetailData->last_name . '</a>';
            //$row[] = $selectUserMasterDetailData->orgId;
            $row[] = $selectUserMasterDetailData->email;
            $row[] = $selectUserMasterDetailData->created_at_format;
            $row[] = $selectUserMasterDetailData->updated_at_format;


            $button_html = '';
            $edit_url = '<button data-toggle="tooltip"  data-original-title="Edit"   class="btn btn-default" onclick="edit_account_head(' . $selectUserMasterDetailData->user_id . ')" ><i class="fa fa-edit" ></i></button>';
            $delete_url = '<button   data-toggle="tooltip"  data-original-title="Delete"   class="btn btn-danger " onclick="account_heads_data_delete(' . $selectUserMasterDetailData->user_id . ')" ><i class="fa fa-trash-o btnIc" ></i></button>';

            //$button_html .= '<div class="btn-group">';
            $button_html .= $edit_url;
            $button_html .= "&nbsp;";
            $button_html .= $delete_url;
            //$button_html .= '</div>';


            $row[] = $button_html;
            $result[] = $row;
        }
        return Datatables::of($result)->escapeColumns(['user_id'])->make(true);
    }
}
