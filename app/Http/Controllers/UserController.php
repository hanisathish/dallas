<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Permission;
use App\Models\UserMaster;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use Config;
use DataTables;
use App\Helpers\CustomHelperFunctions;
use Redirect;
use App\Models\Households;
use App\Models\HouseholdDetails;
use Illuminate\Http\Response;
//use Response;
use Hash;

class UserController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->common_file_upload_path = Config::get('constants.FILE_UPLOAD_PATH');
        $this->common_file_download_path = Config::get('constants.FILE_DOWNLOAD_PATH');

        $this->userSessionData = Session::get('userSessionData');
    }

    /**
     * @Function name : index
     * @Purpose : Member Listin
     * @Added by : Sathish
     * @Added Date : Jul 03, 2019
     */
    public function index(Request $request) {
//        $user = $request->user();
//        $roles = $user->roles;
//        //dd($roles);
//        //dd($user->hasPermissionTo('Event management'));
//            $permissions = $user->permissions;
//            $permissions = $user->getAllPermissions();
//            dd($permissions->toArray());
        $data['title'] = $this->browserTitle . " - Member Directory";
        return view('members.member_list', $data);
    }

    public function create() {
        $data['title'] = $this->browserTitle . " - Member Create";


        $whereArray = array('orgId' => $this->userSessionData['umOrgId']);

        //Loading school
        $data['school_name'] = CustomHelperFunctions::getMasterData('school_name',null,null,$whereArray);
        //Loading name_prefix
        $data['name_prefix'] = CustomHelperFunctions::getMasterData('name_prefix',null,null,$whereArray);
        //Loading name_suffix
        $data['name_suffix'] = CustomHelperFunctions::getMasterData('name_suffix',null,null,$whereArray);
        //Loading marital_status
        $data['marital_status'] = CustomHelperFunctions::getMasterData('marital_status',null,null,$whereArray);
        //Loading grade_name
        $data['grade_id'] = CustomHelperFunctions::getMasterData('grade_name',null,null,$whereArray);

        return view('members.member_create', $data);
    }

    public function view($personal_id) {
        $data['title'] = $this->browserTitle . " - Member View";
        $whereArray = array('personal_id' => $personal_id);
        $data['selectUserMasterDetail'] = UserMaster::selectUserMasterDetail($whereArray,null,null,null,null,null)->get()[0];

        $whereHHArray = array('orgId' => $data['selectUserMasterDetail']->orgId,'hhdUserId'=>$data['selectUserMasterDetail']->user_id);

        $whereHDArray = array('hhdUserId'=>$data['selectUserMasterDetail']->user_id);
        $data['crudHouseholdDetails'] = HouseholdDetails::crudHouseholdDetails($whereHDArray,null,null,null,null,null,null,'1')->get();
        if($data['crudHouseholdDetails']->count() > 0){
            $hhIdValues = array_column($data['crudHouseholdDetails']->toArray(),'hhId');
            $whereInHHDArray = array('household_details.hhId'=>$hhIdValues);
            $data['crudHouseholdsData'] = Households::crudHouseholdsData(null,$whereInHHDArray,null,null,null,null)->get();
            foreach($data['crudHouseholdsData'] as $value){

                $hh_pic_image= url('/assets/uploads/organizations/avatar.png');
                if($value->profile_pic != null){
                    $hh_pic_image_json = json_decode(unserialize($value->profile_pic));
                    $hh_pic_image = $hh_pic_image_json->download_path.$hh_pic_image_json->uploaded_file_name;
                }
                $hhdValue[$value->hhdName][$value->life_stage][] = array("hhId" => $value->hhId,
                        "orgId" => $value->orgId,
                        "hhPrimaryUserId" => $value->hhPrimaryUserId,
                        "hhdName" => $value->hhdName,
                        "createdBy" => $value->createdBy,
                        "hhdId" => $value->hhdId,
                        "hhdUserId" => $value->hhdUserId,
                        "first_name" => $value->first_name,
                        "last_name" => $value->last_name,
                        "life_stage" => $value->life_stage,
                        "hhIsPrimary" => $value->hhIsPrimary,
                        "starmark"=>($value->hhIsPrimary == 1 ? '<i class="fa fa-star" style="color: gold;"></i>' : ''),
                        "hh_pic_image" => $hh_pic_image,
                        "hhIsPrimary" => $value->hhIsPrimary);
            }

            $data['hhdValue'] = $hhdValue;
        }





        return view('members.member_view', $data);
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        $roles = Role::get();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,' . $id, //'email'=>'required|email|unique:users,email,'.$id,
                        //'password'=>'required|min:6|confirmed'
        ]);
        if ($validator->fails()) {
            $user = User::findOrFail($id);
            $roles = Role::get();
            return view('users.edit', compact('user', 'roles'));

            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->except('roles');
        $user->fill($input)->save();
        if ($request->roles <> '') {
            $user->roles()->sync($request->roles);
        } else {
            $user->roles()->detach();
        }

        return redirect()->route('users.index')->with('success', 'User successfully updated.');
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User successfully deleted.');
    }

    /**
     * @Function name : getUserData
     * @Purpose : To fetch getUserData
     * @Added by : Sathish
     * @Added Date : Nov 05, 2018
     */
    public function getUserData(Request $request) {
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

    /**
     * @Function name : userProfileFileUpload
     * @Purpose : To fetch userProfileFileUpload
     * @Added by : Sathish
     * @Added Date : Nov 05, 2018
     */
    public function userProfileFileUpload(Request $request) {
        $result = array();
        $data = array();

        $data = $request->image;
        $user_id=$request->user_id;

        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);

        list($dt, $img) = explode(":", $type);
        list($imgclo, $extension) = explode("/", $img);

        $data = base64_decode($data);
        $imageName = time() . '.' . $extension;
        $destinationPath = $this->common_file_upload_path['PROFILE_PIC_UPLOAD_PATH'] . DIRECTORY_SEPARATOR . $this->userSessionData['umOrgId'] . DIRECTORY_SEPARATOR . "profile" . DIRECTORY_SEPARATOR;


        $downloadPath = $this->common_file_download_path['PROFILE_PIC_DOWNLOAD_PATH'] . '/' . $this->userSessionData['umOrgId'] . '/' . "profile" . '/';


        file_put_contents($destinationPath . $imageName, $data);


        $upload_data = array('uploaded_path' => $destinationPath, 'download_path' => $downloadPath, 'uploaded_file_name' => $imageName, 'original_filename' => $imageName, 'upload_file_extension' => $extension, 'file_size' => 0);
        $jsonformat = serialize(json_encode($upload_data));

        $update_details = array("profile_pic" => $jsonformat);
        $whereUMUpdateArray = array('users.id' => $user_id);

        UserMaster::crudUserMaster($whereUMUpdateArray, null, null, null, null, $update_details, null, null);
        return "done";
    }

    /**
     * @Function name : userMasterStore
     * @Purpose : User master insert/update
     * @Added by : Sathish
     * @Added Date : Jul 02, 2018
     */
    public function userMasterStore(Request $request) {
        // BELOW TWO FUNCTION IS BEEN USED FOR DISABLE THE TRANSACTION
        set_error_handler(null);
        set_exception_handler(null);
        DB::beginTransaction();

        try {
            $userMasterData = $request->except('documentattached');

            $randomString = strtolower(str_random(4));


            if($this->userSessionData['umOrgId'] > 0){

                $userMasterData['orgId'] = $this->userSessionData['umOrgId'];
                $userMasterData['referal_code'] = substr($request->first_name, 0, 4) . $randomString;
                $lastUserId = UserMaster::orderBy('id','DESC')->first();
                $newPersonal_id = str_pad($lastUserId->id + 1, 10, "0", STR_PAD_LEFT);

                $userMasterData['personal_id'] = $newPersonal_id;
                $userMasterData['householdName'] = $request->first_name."'s household";
                $userMasterData['password'] = "password";
                $userMasterData['address'] = $request->street_address.",".$request->apt_address.",".$request->city_address.",".$request->state_address." - ".$request->zip_address;

                $insertUser = User::create($userMasterData);

                $request['roles'] = 2;
                if ($request->roles <> '') {
                    $insertUser->roles()->attach($request->roles);
                }
                DB::commit();

                return redirect()->back()->with('message', 'User created successfully');
                return redirect()->route('people/member_create')->with('success', "User created successfully");

            }else{
                return Redirect::back()->withErrors( $e->getMessage());
                //return redirect()->route('people/member_create')->with('failure', $e->getMessage());
            }


        }catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return Redirect::back()->withErrors( $e->getMessage());
        }
        return redirect('people/member_directory');
    }

	public function getUsersList(Request $request) {
            $search = $request->phrase;
            $eventId = $request->eventId;
            //dd($search);exit();
            $usersList = UserMaster::getUserListForAutocomplete($search,$eventId); //'id', 'first_name', 'last_name'
            $users = array();

            foreach ($usersList as $user) {
                $disabled = true;
                if($user->chId == null || $user->chId == "null"){
                    $disabled = false;
                }
                $users[] = array("text"=>$user->first_name." ".$user->last_name,"id"=>$user->id,"disabled"=>$disabled);
            }
		//print_r($usersList);

		return response()->json(
							   $users
						);
	}


     // Created By Santhosh 

    public function userProfilePage() {

        $data['title'] = $this->browserTitle . " - Profile";
    
        $user_id= Auth::id();

        $whereArray = array('users.id' => $user_id);   
        
        $data['user'] = $user_id;
     		        
        $data['get_profile_info'] = UserMaster::selectFromUserMaster($whereArray,null,null,null,null,null,null,'1')->get()[0];
        
        return view('users.profile_settings', $data);
        
        
    }

    // Created By Santhosh 
    public function userProfileUpdate(Request $request) {

        $data['title'] = $this->browserTitle . " - Update Profile";
        $data['userid'] = $request->userid;

        $whereArray = array('users.id' => $request->userid);
        $data['get_profile_info'] = UserMaster::selectFromUserMaster($whereArray,null,null,null,null,null,null,'1')->get()[0];

        return view('users.profile_update',$data);
   }

   
   // Created By Santhosh 
   public function storeUserProfile(Request $request)
   {
      
        $insertData = $request->all();

        $userid = $request->userid;

        //$profile_pic = "";

        $whereArray = array('users.id' => $userid);

        $get_profile_info = UserMaster::selectFromUserMaster($whereArray,null,null,null,null,null,null,'1')->get()[0];

       /*if (isset($request->profile_pic) && $request->profile_pic != "") {
            
            $profile_pic = $this->resourceFileUpload($request->profile_pic);

        } else {

            $profile_pic = $get_profile_info->profile_pic;
        }*/

        $insertData = $request->except(['_token','userid']);

        //$insertData['profile_pic'] = $profile_pic;

        UserMaster::where("id",$userid)->update($insertData);

        Session::flash('message', 'Profile has been updated successfully');

        return redirect('people/profile_list');

   }


   // Created By Santhosh 
   private function resourceFileUpload($file) {

        $extension = $file->getClientOriginalExtension();

        $imageName = basename($file->getClientOriginalName(), ("." . $extension));

        $imageName .= "_" . time() . '.' . $extension;
        
        $destinationPath = $this->common_file_upload_path['PROFILE_PIC_UPLOAD_PATH'] . DIRECTORY_SEPARATOR . Auth::user()->orgId . DIRECTORY_SEPARATOR . "profile" . DIRECTORY_SEPARATOR;

        $downloadPath = $this->common_file_download_path['PROFILE_PIC_DOWNLOAD_PATH'] . '/' . Auth::user()->orgId . '/' . "profile" . '/';

        $file->move(
                $destinationPath, $imageName
        );

        $upload_data = array('uploaded_path' => $destinationPath, 'download_path' => $downloadPath, 'uploaded_file_name' => $imageName, 'original_filename' => $imageName, 'upload_file_extension' => $extension, 'file_size' => 0);
        $jsonformat = serialize(json_encode($upload_data));

        return $jsonformat;
   }

   
    // Created By Santhosh 
    public function userChangePassword(Request $request) {

        $form_post = $request->all();
		
	    $data['title'] = $this->browserTitle . " - Change Password";
       
        if($form_post) {
			
		    // setup rules for validation of user input
            $rules = [
                'cur_pwd' => 'required',
                'new_pwd' => 'required|min:6|max:15',
                'rep_pwd' => 'required|min:6|max:15|same:new_pwd',
            ];
            
            $messsages = array(
                'cur_pwd.required' => 'The Current Password field is required.<br>',
                'new_pwd.required' => 'The New Password field is required.<br>',
                'new_pwd.min' => 'The New Password field must be at least 6 characters in length.<br>',
                'new_pwd.max' => 'The New Password field can not exceed 15 characters in length.<br>',
                'rep_pwd.required' => 'The Confirm Password field is required.<br>',
                'rep_pwd.min' => 'The Confirm Password field must be at least 6 characters in length.<br>',
                'rep_pwd.max' => 'The Confirm Password field can not exceed 15 characters in length.<br>'
            );
            
            $validator = Validator::make($request->all(), $rules, $messsages);
			
			if ($validator->fails()) {
				
            return response()->json(array(
                'status' => false,
                'errors' => $validator->getMessageBag()->toArray()
                    ), 200);
            }
            else {
		 
		        $curPwd = $form_post['cur_pwd'];
                $newPwd = $form_post['new_pwd'];            
				$user_id= Auth::id();
		        
				$User = UserMaster::where('id', $user_id)->first();
				
				if ($User) {
                        $oldHashedPassword = $User->password;
                        if (Hash::check($curPwd, $oldHashedPassword)) {
							
                            // The passwords match...
                            $User->password = bcrypt($newPwd);

                            UserMaster::where('id', $User->id)->update(['password' => $User->password]);

                            $messsages = array(
                                'success' => 'Your Password has been changed successfully.',
                            );
                        }
                        else {
                            $messsages = array(
                                'error' => 'Current password does not match',
                            );
                        }
                        return response()->json(array(
                            'status' => false,
                            'errors' => $messsages
                        ), 200);
                } 
			}
		}else {   
        
		     return view('users.changepassword', $data);
		}
        
    }

}
