<?php

namespace App\Http\Controllers;
//use Illuminate\Support\Facades\DB;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Middleware;
use Redirect;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;
use Validator;

use App\Role;
use App\Permission;
use App\Models\Organization;
use App\Models\ModelHasRoles;
use App\Models\MasterLookupData;
use Hash;
use DB;
use Config;
use Mail;

use App\Models\Roles;
use Camroncade\Timezone\Facades\Timezone;

use App\Models\UserMaster;
use App\Models\CommTemplate;
use App\Helpers\CommunicationHelper;

class PassportController extends Controller {

    
    public function __construct(Request $request) {

        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->common_file_upload_path = Config::get('constants.FILE_UPLOAD_PATH');
//dd("org_domainpassport==",\Request::route('org_domain'),$request->org_domain,$request->route('org_domain'));        
        if (\Request::route('org_domain')) {
            $this->org_domain = \Request::route('org_domain');
        } else {
            $this->org_domain = \Request::segment(3);
        }

        //dd("URL : ".url('/login').'/'.$this->org_domain);
        //dd($this->org_domain);
        //$this->crudOrganizationData = array();
        $whereArray = array('orgDomain' => $this->org_domain);
        $crudOrganization = Organization::crudOrganization($whereArray,null,null,null,null,null,null,'1')->get();
        //dd($crudOrganization);
        //if($crudOrganization->count() > 0){
        $this->crudOrganizationData = $crudOrganization;
        //}
        //dd($this->crudOrganizationData);
    }
    
    public function login_page(Request $request) {
        
        $data['title'] = $this->browserTitle . " - Login";
        $data['crudOrganizationData'] = $this->crudOrganizationData;
        return view('auth.login', $data);
    }
    
	
	
	/*
     * @Function name : userForgotPassword
     * @Purpose : userForgotPassword
     * @Added by : Santhosh    
     * @Added Date : Jan 23, 2020
     */
	 
    public function forgotpassword() {
        
        $data['title'] = $this->browserTitle . " - Forgot Password";
        
        $data['dateTimezone'] = Timezone::selectForm(
        '', 
        'Select Timezone', 
        ['class' => 'form-control', 'name' => 'orgTimeZone', 'id' => 'orgTimeZone']
        );
        $data['crudOrganizationData'] = $this->crudOrganizationData;
        
        return view('auth.forgotpassword', $data);
  
    }
	
	
	
	
	/**
     * @Function name : userForgotPassword
     * @Purpose : userForgotPassword
     * @Added by : Santhosh    
     * @Added Date : Jan 23, 2020
     */
    
   public function userForgotPassword(Request $request)
   {
       DB::beginTransaction();

        try {
            
			    $data['title'] =  "Forgot Password";
				
				$User = UserMaster::where('email', $request->get('email'))->first();
			
				if($User) {
					
					$id = $User->id;
					
					//$random_password = str_random(8);
					
					//$password = Hash::make($random_password);	
					
					//print($id).'<br>';
					//print($password).'<br>';
					//print($random_password).'<br>';
					
					
					//DB::enableQueryLog();					 
					// Update in DB					
					//$updatePassword = UserMaster::where('id', $id)->update(['password' => $password]);					
					//$query = DB::getQueryLog();
                    //print_r($query);
					//exit;
					
                    // Get Templates
					
					if(isset($this->orgId)){
						           						
						  $templates = CommTemplate::where('org_id', $this->orgId)->select("id", "tag", "name", "subject","body")->get();
						
					}
					else {		
					
						  $templates = CommTemplate::where('org_id', 0)->select("id", "tag", "name", "subject","body")->get();
					}
					
					
                    //print"<pre>";					
                    //print_r($templates);
					
                    foreach($templates as $key=>$val){
						
						if($val->tag == "forgot_password"){
							
							 $template_subject = $val->subject;
							 $template_body = $val->body;
						}
						
					}
                  					
					
					// Send Mail
					
					$subject = $template_subject;
					$to_email= $request->get('email');
		            $from_email='dummyproj007@gmail.com';
					
					$pwd_url = url("/") . "/changecustomerpassword/".$User->id;
					
					$message ="<h3>Password Recovery</h3>"."<br/>";
		            $message.= "Hello,<br>";		
					$message.= "<h4>".$template_body."</h4><br />";
					$message.= '<a href="' . $pwd_url . '" class="btn bg-blue btn-block">Reset Password</a><br/><br />';
					$message.= 'Thanks!<br />';	
		

					//print_r($message);
					//exit;				
					
					
					$send_mail = Mail::send(array(), array(), function ($email) use ($subject, $to_email, $from_email, $message) {
		            $email->to($to_email)
				           ->from($from_email)
					       ->subject($subject)
					       ->setBody(nl2br($message), 'text/html');
	             	});
					
				}
				else 
				{ 
					return redirect()->back()->with('message', 'Email does not exists');
						
				}
            
            DB::commit();
            //return view('auth.changepwd');
            return redirect()->back()->with('message', 'Please check your email for instructions to reset your password.');
            
        }
        catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();            
            //return response()->json(['result_code' => 0,'message' => $e->getMessage()], 200);
            return Redirect::back()->withErrors( $e->getMessage());
            
            
           // something went wrong with the transaction, rollback
        }  catch (\Exception $e) {
            DB::rollback();            
            return Redirect::back()->withErrors( $e->getMessage()); 
        }
   }
	

	
	
	/**
     * Change password.
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function changeCustomerPassword(Request $request) {
		
		
		//dd($request->segment(2));
		
        $data['title'] = $this->browserTitle . " - Change Customer Password";
		
		$data['crudOrganizationData'] = $this->crudOrganizationData;
		
		$data['getUserListsCount'] = 0;
        $data['getUserLists'] = '';
	  
        if($request->segment(2) > 0) {
			
            $whereArray = array('id'=>$request->segment(2));			
            $getUserLists = UserMaster::crudUserMaster($whereArray,null,null,null,null,null,null,'1')->get();
			
			//dd($getUserLists);
			
			$data['getUserListsCount'] = $getUserLists->count();
            $data['getUserLists'] = $getUserLists[0];
			
		}			
   		
        $data['view_action'] = $request->segment(2);
		$data['recover_pwd'] = "recovery";
		return view('users.customer_recover_pwd', $data);
    }



    /**
     * Change password.
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function customerPwdStore(Request $request) {

        DB::beginTransaction();

        try {
			
			$id = $request->id;
			
            $customerData = $request->except('submitCusPwd');
			
			$customerData['password'] = bcrypt($request->input('password'));

            unset($customerData['_token'],$customerData['submitCusPwd'],$customerData['repeat_password']);
						
            if($id > 0) {
							
                UserMaster::updateUserMaster($customerData,array('id'=>$id));
				
            }
			
            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            dd("error",$e);
            //return redirect('/banker_dashboard#tab_3/error');
        }
        return redirect('/');
    }
	
	
	
	
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        
        $data['title'] = $this->browserTitle . " - Create Account";
        //$data['dateTimezone'] = Timezone::selectForm();
        $data['dateTimezone'] = Timezone::selectForm(
        '', 
        'Select Timezone', 
        ['class' => 'form-control', 'name' => 'orgTimeZone', 'id' => 'orgTimeZone']
        );
        $data['crudOrganizationData'] = $this->crudOrganizationData;
        
        return view('auth.register', $data);
        
        
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
        
        $data['title'] = $this->browserTitle . " - Login";
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];//dd($credentials);
        //admin@admin.com
        if (auth()->attempt($credentials)) {
            $userData = Auth::user();
            $whereArrayUser = array('users.id' => $userData['id']);
            $data['selectFromUserCustom'] = $selectFromUserCustom = User::selectFromUserCustom($whereArrayUser)->get();
            //dd($selectFromUserCustom[0]['user_id']);
            //return response()->json(['userData' => $userData->only(['id', 'name', 'email'])], 200);
            $token = auth()->user()->createToken('dallas')->accessToken;
            $resultSetSessionArray["umId"] = $userData['id'];
            $resultSetSessionArray["umName"] = $selectFromUserCustom[0]['user_name'];
            $resultSetSessionArray["umEmail"] = $selectFromUserCustom[0]['user_email'];
            $resultSetSessionArray["umUserRoleId"] = $selectFromUserCustom[0]['user_role_id'];
            $resultSetSessionArray["umUserRoleName"] = $selectFromUserCustom[0]['user_role_name'];
            $resultSetSessionArray["umUserRoleTag"] = $selectFromUserCustom[0]['user_role_tag'];
            $resultSetSessionArray["umOrgId"] = $selectFromUserCustom[0]['orgId'];
            $resultSetSessionArray["umPersonal_id"] = $selectFromUserCustom[0]['personal_id'];
            
            Session::put('userSessionData', $resultSetSessionArray);

            //dd($resultSetSessionArray,Session::get('userSessionData'));
            if ($request->segment(1) == "webapp") {

                return redirect('/home');
            } else {
                //return redirect('/home');
                return response()->json(['result_code' => 1,'token' => $token, 'result' => $resultSetSessionArray], 200);
            }
        } else {
            if ($request->segment(1) == "webapp") {
                $errors = new MessageBag(['username' => ['Username / password invalid.']]);
                return Redirect::back()->withErrors($errors)->withInput(Input::except('password'));
            } else {
                return response()->json(['result_code' => 2,'failure' => 'Username / password invalid.'], 200);
            }
        }
    }

    public function organizationRegister(Request $request) {

        DB::beginTransaction();

        try {
            
            $validator = Validator::make($request->all(), [
                        'orgName' => 'required',
                        'first_name' => 'required',
                        'email' => 'required|email',
                        'username' => 'required',
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
                  ->select(array(DB::raw("'$insertOrganization->orgId'"),'mldKey','mldValue','mldType','mldOption','mldOrder',DB::raw("'$todaysDate'"),DB::raw("'$todaysDate'")));
                
                
                DB::table('master_lookup_data')->insertUsing(['orgId','mldKey','mldValue','mldType','mldOption','mldOrder','created_at','updated_at'], $selectMasterLookupData);
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


            $urlHere = url('/login').'/'.$request->orgDomain;
            DB::commit();
            $logindetails = "Login URL : <a href='".$urlHere."'>".$urlHere."</a>";
            //, 'logindetails' => $logindetails
            return response()->json(['result_code' => 1, 'message' => 'Account has been created', 'logindetails' => $logindetails], 200);
            return redirect()->back()->with('message', 'Account has been created');
            
            
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

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details() {
        return response()->json(['user' => auth()->user()], 200);
    }

    /**
     * Display Logout Page
     *
     * @return View
     */
    public function logout(Request $request) {
        if ($request->segment(1) == "webapp") {
            Auth::logout();
            Session::flush();
            return redirect('/login/'.$request->segment(3));
        } else {
            if (Auth::check()) {
                Auth::user()->AauthAcessToken()->delete();
            }
        }

        return response()->json(['status' => 'Logout'], 200);
        
    }

    /**
     * Display Logout Page
     *
     * @return View
     */
    public function superadmin_logout(Request $request) {
        Auth::logout();
        Session::flush();
        return redirect('/');
        
    }
    
    /**
     * @Function name : checkOrganizationDomain
     * @Purpose : Check org domain exist
     * @Added by : Sathish    
     * @Added Date : Nov 07, 2018
     */
    
   public function checkOrganizationDomain(Request $request)
   {
       $whereArrayAT = array('orgDomain' => $request->orgDomain);
       $selectFromOrganization = Organization::selectFromOrganization($whereArrayAT)->get()->count();
       if($selectFromOrganization > 0){
           return "found";
       }
       return "notfound";
   }

   /**
     * @Function name : checkUniqueEmailPerOrganization
     * @Purpose : Check org per email exist
     * @Added by : Sathish    
     * @Added Date : Nov 07, 2018
     */
    
    public function checkUniqueEmailPerOrganization(Request $request)
    {
        $whereArrayAT = array('orgId' => $request->orgId,'email' => $request->email);
        $selectFromUserMaster = UserMaster::selectFromUserMaster($whereArrayAT)->get()->count();
        if($selectFromUserMaster > 0){
            return "found";
        }
        return "notfound";
    }
    
    
    /**
     * @Function name : checkUniqueUsername
     * @Purpose : Check username exist
     * @Added by : Sathish    
     * @Added Date : Aug 13, 2020
     */
    
    public function checkUniqueUsername(Request $request)
    {
        //'orgId' => $request->orgId,
        $whereArrayAT = array('username' => $request->username);
        $selectFromUserMaster = UserMaster::selectFromUserMaster($whereArrayAT)->get()->count();
        if($selectFromUserMaster > 0){
            return "found";
        }
        return "notfound";
    }

    /**
     * @Function name : checkUniqueEmail
     * @Purpose : Check email exist
     * @Added by : Sathish    
     * @Added Date : Oct 01, 2019
     */
    
   public function checkUniqueEmail(Request $request)
   {
       $whereArrayAT = array('email' => $request->email);
       $selectFromUserMaster = UserMaster::selectFromUserMaster($whereArrayAT)->get()->count();
       if($selectFromUserMaster > 0){
           return "found";
       }
       return "notfound";
   }
   
   /**
     * @Function name : memberRegister
     * @Purpose : memberRegister
     * @Added by : Sathish    
     * @Added Date : Nov 07, 2018
     */
    
   public function memberRegister(Request $request)
   {
       DB::beginTransaction();

        try {
            
            $validator = Validator::make($request->all(), [
                        'username' => 'required',
                        'first_name' => 'required',
                        'email' => 'required|email',
                        'password' => 'required'
            ]);
            if ($validator->fails()) {
                
                return Redirect::back()->withErrors($validator->errors())->withInput(Input::except('password'));
            }
            $randomString = strtolower(str_random(4));
            
            $rolesAdminData = DB::table('roles')->where('orgId',$request->orgId)->where('role_tag','member')->get();
            
            
            
            $userFormData = $request->except('confirm_password');
            $userFormData['orgId'] = $request->orgId;
            $userFormData['referal_code'] = substr($request->first_name, 0, 4) . $randomString;
            $lastUserId = UserMaster::orderBy('id','DESC')->first();
            $newPersonal_id = str_pad($lastUserId->id + 1, 10, "0", STR_PAD_LEFT);

            $userFormData['personal_id'] = $newPersonal_id;
            $userFormData['householdName'] = $request->first_name."'s household";

            $insertUser = User::create($userFormData);
            
            //insert into model_has_roles with admin role
            DB::table('model_has_roles')->insert(array('role_id'=>$rolesAdminData[0]->id,'model_type'=>'App\User','model_id'=>$insertUser->id));
            

            //generate welcome email communication
            $userIds = [$insertUser->id];
            if(count($userIds) > 0){
                CommunicationHelper::generateCommunications('welcome', $request->orgId, 1, $insertUser->id, $userIds);
            }

            
            

            DB::commit();
            return redirect()->back()->with('message', 'Account has been created');
            
        }
        catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();            
            //return response()->json(['result_code' => 0,'message' => $e->getMessage()], 200);
            return Redirect::back()->withErrors( $e->getMessage());
            
            
        // something went wrong with the transaction, rollback
        }  catch (\Exception $e) {
            DB::rollback();
            //return response()->json(['result_code' => 0,'message' => $e->getMessage()], 200);
            return Redirect::back()->withErrors( $e->getMessage());
            
            
        }
   }
   
   
    
   
   
   
   
}