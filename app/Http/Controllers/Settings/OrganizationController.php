<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Camroncade\Timezone\Facades\Timezone;
use DB;
use Config;
use yajra\Datatables\Datatables;
use Auth;
use Redirect;
use Validator;
use App\User;
use App\Role;
use App\Permission;
use App\Models\Location;
use App\Models\Resources;
use App\Models\Roles;
use App\Models\Organization;
use App\Models\MasterLookupData;
use App\Models\UserMaster;
use App\Models\CommTemplate;


class OrganizationController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->common_file_upload_path = Config::get('constants.FILE_UPLOAD_PATH');
        $this->common_file_download_path = Config::get('constants.FILE_DOWNLOAD_PATH');
        $this->userSessionData = Session::get('userSessionData');
		$this->authUserId = $this->userSessionData['umId'];
    }

    public function index() {

        $data['title'] = $this->browserTitle . " - Organization Management";

        return view('settings.organization.index', $data);
    }


     public function getOrganizationList(){
		
        $result = array();
				
 	    $organizations = Organization::select("orgId", "orgName", "orgDomain")->orderBy("orgId", "desc")->get();
        			
        $i = 1;
        foreach ($organizations as $org) {
			
            $row = [$i, $org->orgName, $org->orgDomain];
			$viewLink = "";
            $editLink = url("/settings/organization/manage/".$org->orgId);
            //$row[] = "<a href='".$editLink."'><i class='fa fa-pencil-square-o'></i></a>";
			$row[] = '<a href='.$editLink.'> <i class="fa fa-pencil-square-o"></i></a> <a onclick="organization_data_delete('.$org->orgId.')"> <i class="fa fa-trash"></i></a>';
            $result[] = $row;
            $i += 1;
        }

        return Datatables::of($result)->rawColumns([3])->make(true);
							
    }
	
	
	public function list(Request $request){
			
        $payment_gateways = Organization::listOtherPaymentGatewaysMethods($request->search['value']);		

        return DataTables::of($payment_gateways)
		
                        ->addColumn('action', function($row) {							
                            $btn = '<a class="nav-link" href="payment_others/edit/'.$row->other_payment_method_id.'"><i class="fa fa-lg"></i>Edit</a>';
                            return $btn;
                        })

                        ->rawColumns(['action','image'])
                        ->make(true);
    }
	
	
	
	public function organizationRegister(Request $request) {

  
        DB::beginTransaction();

        try {
            
            $validator = Validator::make($request->all(), [
                        'orgName' => 'required',
                        'first_name' => 'required',
                        'email' => 'required|email',
                        'password' => 'required',
                        'orgDomain' => 'required',
            ]);
            if ($validator->fails()) {
                
                return Redirect::back()->withErrors($validator->errors())->withInput(Input::except('password'));
            }
            
            


            $randomString = strtolower(str_random(4));
            $orgFormData = $request->except('first_name','email','username','password','confirm_password');
            //Insert into organization table
            $insertOrganization = Organization::create($orgFormData);
            
            if($insertOrganization->orgId > 0){
                
                //Insert into roles table
                $select = Role::where('orgId',0)
                  ->where('role_tag','!=','superadmin')
                  ->select(array(DB::raw("'$insertOrganization->orgId'"),'name','guard_name','role_tag'));
                DB::table('roles')->insertUsing(['orgId','name','guard_name','role_tag'], $select);
                //////
                
                //Insert into permissions table
                $selectPermission = Permission::where('orgId',0)
                  //->where('role_tag','!=','superadmin')
                  ->select(array(DB::raw("'$insertOrganization->orgId'"),'name','guard_name'));
                
                
                DB::table('permissions')->insertUsing(['orgId','name','guard_name'], $selectPermission);
                //////
                
                //insert into role_has_permissions with admin role
                $rolesAdminData = DB::table('roles')->where('orgId',$insertOrganization->orgId)->where('role_tag','admin')->get();
                
                
                $permissionsData = DB::table('permissions')->where('orgId',$insertOrganization->orgId)->get();
                if($permissionsData->count() > 0){
                    foreach($permissionsData as $permissionsDataValue){
                        $data_permission_insert[] = array('permission_id'=>$permissionsDataValue->id,'role_id'=>$rolesAdminData[0]->id);
                    }
                    DB::table('role_has_permissions')->insert($data_permission_insert);
                }
                
                //////////

                //insert into role_has_permissions with other role
                $rolesOtherData = DB::table('roles')->where('orgId',$insertOrganization->orgId)->where('role_tag','!=','admin')->get();
                
                
                $permissionsOtherData = DB::table('permissions')->where('orgId',$insertOrganization->orgId)->first();

                
                foreach($rolesOtherData as $rolesOtherDataValue){
                    $data_permission_other_insert[] = array('permission_id'=>$permissionsOtherData->id,'role_id'=>$rolesOtherDataValue->id);
                }

                DB::table('role_has_permissions')->insert($data_permission_other_insert);
                ///////
                
                $userFormData = $request->except('orgName','orgTimeZone','confirm_password');
                $userFormData['orgId'] = $insertOrganization->orgId;
                $userFormData['referal_code'] = substr($request->first_name, 0, 4) . $randomString;
                $lastUserMasterDet = UserMaster::orderBy('id','DESC')->get();
                $lastUserId=0;
                if($lastUserMasterDet->count() > 0){
                    $lastUserId = $lastUserMasterDet->first()->id;
                }
                $newPersonal_id = str_pad($lastUserId + 1, 10, "0", STR_PAD_LEFT);
                
                $userFormData['personal_id'] = $newPersonal_id;
                $userFormData['householdName'] = $request->first_name."'s household";
                $userFormData['full_name'] = $request->first_name;
            
                $insertUser = User::create($userFormData);
                
                //insert into model_has_roles with admin role
                // DB::table('model_has_roles')->insert(array('role_id'=>$rolesAdminData[0]->id,'model_type'=>'App\User','model_id'=>$insertUser->id));
                $insertUser->roles()->attach($rolesAdminData[0]->id);
                //////////
                $todaysDate=date('Y-m-d H:i:s');
                //Insert into master_lookup_data table
                $selectMasterLookupData = MasterLookupData::where('orgId',0)
                  //->where('role_tag','!=','superadmin')
                  ->select(array(DB::raw("'$insertOrganization->orgId'"),'mldKey','mldValue','mldType','mldOption',DB::raw("'$todaysDate'"),DB::raw("'$todaysDate'")));
                
                
                DB::table('master_lookup_data')->insertUsing(['orgId','mldKey','mldValue','mldType','mldOption','created_at','updated_at'], $selectMasterLookupData);
                //////
                
                // $request['roles'] = 2;
                // if ($request->roles <> '') {
                //     $insertUser->roles()->attach($request->roles);
                // }
                
                
                //Insert into communication templates table
                $selectTemplaes = CommTemplate::where('org_id',0)
                  ->select(array(DB::raw("'$insertOrganization->orgId'"),'tag', 'name','subject','body'));
                
                
                DB::table('comm_templates')->insertUsing(['org_id','tag', 'name','subject','body'], $selectTemplaes);
                //////
                
                
            }else{
                //return redirect()->route('register')->with('failure', $e->getMessage());
                return response()->json(['result_code' => 0,'message' => $e->getMessage()], 200);
            }
            
            //Make organization specific directory 
            $orgIdFolder = $this->common_file_upload_path['PROFILE_PIC_UPLOAD_PATH'] . DIRECTORY_SEPARATOR . $insertOrganization->orgId;

            \File::makeDirectory($orgIdFolder, $mode = 0777, true, true);

            $orgProfilePicFolder = $this->common_file_upload_path['PROFILE_PIC_UPLOAD_PATH'] . DIRECTORY_SEPARATOR . $insertOrganization->orgId . DIRECTORY_SEPARATOR . "profile";

            \File::makeDirectory($orgProfilePicFolder, $mode = 0777, true, true);

            //$urlHere = url('/login').'/'.$request->orgDomain;
            DB::commit();
			
            //$logindetails = "Login URL : <a href='".$urlHere."'>".$urlHere."</a>";
            //, 'logindetails' => $logindetails
            //return response()->json(['result_code' => 1, 'message' => 'Account has been created', 'logindetails' => $logindetails], 200);
            //return redirect()->back()->with('message', 'Account has been created');
			
            return redirect('settings/organization');
			
            
        }catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();            
            return response()->json(['result_code' => 0,'message' => $e->getMessage()], 200);
            return Redirect::back()->withErrors( $e->getMessage());
            
            
        // something went wrong with the transaction, rollback
        }  catch (\Exception $e) {
            DB::rollback();
            return response()->json(['result_code' => 0,'message' => $e->getMessage()], 200);
            return Redirect::back()->withErrors( $e->getMessage());
            
            
        }
    }
	

    public function createOrEditPage(Request $request) {
		
        $data['title'] = $this->browserTitle . " - Organization List";	
		
		$data['org_id'] =  \Request::segment(4);
		
		$orgId = $request->segment(4);
		
		if(isset($orgId)){
			
			$org_Id = $orgId;
		}
		else 
		{
			$org_Id = "";
		}
		

        $data['dateTimezone'] = Timezone::selectForm(
        '', 
        'Select Timezone', 
        ['class' => 'form-control', 'name' => 'orgTimeZone', 'id' => 'orgTimeZone']
        );

        //dd($org_Id);
		
        if(isset($orgId)){
        
		    $data['getOrganizationUserValues'] = $getOrganizationUserValues = Organization::getOrganizationUserValues($org_Id);
		    $data['user_Id'] = $data['getOrganizationUserValues']->id;
		}
		else {
			
			$getOrganizationUserValues = "";
			$user_Id = "";
		}
		
        return view('settings.organization.create', $data);
		
    }
	
	
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $updateData = $request->all();

        $orgId = $request->orgId;
		
        $userId = $request->userId;
		
		//dd($updateData);
        //validation rules
		
        $updateOrgData = $request->except(['userId','email','first_name','orgId','_token']);
		
        $updateUserData = $request->except(['userId','orgName','orgDomain','_token']);

        if($orgId > 0) {
			
		     //update
            $updateData['updatedBy']= Auth::id();
			
            Organization::where("orgId",$orgId)->update($updateOrgData);
			
            UserMaster::where("id",$userId)->update($updateUserData);
			
        }
        //return response()->json([ 'success' => '1',"message" => '<div class="alert alert-success"><strong>Saved!</strong></div>']);			
        return redirect('settings/organization');
    }


    public function deleteOrganizationById(Request $request)
    {

        $whereArray = array('orgId' => $request->get('orgId'));
        $updateAHDeletedStatus = array('deleted_at' => now(), 'deletedBy' => $this->authUserId);
        Organization::crudOrganization($whereArray, null, null, null, null, $updateAHDeletedStatus, null, null);
    }
	
}
