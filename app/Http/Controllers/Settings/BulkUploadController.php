<?php
namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Config;

use App\Models\MyContact;
use App\Models\MyContactGroup;
use App\Models\ContactGroupMap;
use App\Models\UserMaster;
use App\User;
use App\Models\ModelHasRoles;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Excel;
use Validator;
use Redirect;
use PDO;

class BulkUploadController extends Controller
{

    public function __construct()
    {
        
        $this->middleware(function ($request, $next) {
            $this->userguard = Auth::guard('web')->user();

            return $next($request);
        });
    }

    /**
     * @Function name : index
     * @Purpose :  Bulk Upload listing
     * @Added by : Sathish    
     * @Added Date : Jul 03, 2019
     */
    public function index(Request $request)
    {
        $data['title'] = "Bulk Upload";
        if($this->userguard->roles[0]->name == "superadmin"){
            $whereArray = null;
        }else{
            $whereArray = array('contact_group.createdBy' => $this->userguard->id);    
        }
        $data['crudMyContactGroup'] = MyContactGroup::crudMyContactGroup($whereArray,null,null,null,null,null,null,'1')->get();
        //dd($data['crudMyContactGroup']);
        return view('settings.bulkupload.index',$data);
    }

    /**
     * @Function name : bulkImportExcel
     * @Purpose :  bulkImportExcel
     * @Added by : Sathish    
     * @Added Date : Jul 03, 2019
     */
    public function bulkImportExcel(Request $request)
    {
        $validator = Validator::make(
            [
                'file'      => Input::file('import_file'),
                'extension' => strtolower(Input::file('import_file')->getClientOriginalExtension())
            ],
            [
                'file'          => 'required',
                'extension'      => 'required|in:xlsx,xls,csv'
            ]  
            );

        $validator1=Validator::make($request->all(),[
            //use this
                'bulk_upload_type' => 'required'
            
            ]);
        // $validator = Validator::make($request->all(), [
        //             'import_file' => 'required|mimes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        //             //'required|mimes:xlsx,xls',
        //             'bulk_upload_type' => 'required'
        // ]);
        if ($validator1->fails()) {
            // dd($validator->errors());
            return Redirect::back()->withErrors($validator1->errors());
        }
        if ($validator->fails()) {
            // dd($validator->errors());
            return Redirect::back()->withErrors($validator->errors());
        }

        
        if(Input::hasFile('import_file')){
            DB::beginTransaction();
            $path = Input::file('import_file')->getRealPath();
            
			$data = Excel::load($path, function($reader) {
                
            })->get();
            $headerRow = $data->first()->keys()->toArray();
			
			if(!empty($data) && $data->count()){
                $file = Input::file('import_file');

                $countheader = count($headerRow); 
                // dd($headerRow,$countheader);
                if($request->input('bulk_upload_type') == 'contact_bulk'){
                    if($countheader == 3  && in_array('email',$headerRow) && in_array('first_name',$headerRow) && in_array('last_name',$headerRow)){
                        foreach ($data as $key => $value) {
                            if($value->email && $value->first_name){
                                $insert[] = ['c_email' => $value->email, 'c_f_name' => $value->first_name, 'c_l_name' => $value->last_name,'orgId' => $this->userguard->orgId,'createdBy' => $this->userguard->id];
                            }                            
                        }
                        // dd($insert);
                        if(!empty($insert)){ //first()
                            $latestMyContact = MyContact::select('id')->orderBy('id', 'DESC')->get();
                            if($latestMyContact->count() > 0){
                                $latestMyContactId = $latestMyContact->first()->id;
                            }else{
                                $latestMyContactId = 1;
                            }
                            // dd($latestMyContactId);
                            MyContact::insert($insert);

                            //insert into group if group name is entered
                            if($request->input('group_id')){
                                $group_id = $request->input('group_id');
                                if($request->input('grp_name_enter')){

                                    $myContactGroupFormData = $request->except('bulk_upload_type','group_id','import_file');

                                    if($this->userguard->roles[0]->name == "superadmin"){
                                        $myContactGroupFormData['orgId'] = $this->userguard->orgId;
                                    }else{
                                        $myContactGroupFormData['orgId'] = $this->userguard->orgId;
                                    }
                                    $myContactGroupFormData['createdBy'] = $this->userguard->id;

                                    $myContactGroupFormData['group_name'] = $request->input('grp_name_enter');
                                    
                                    $insertMyContactGroupDetails = MyContactGroup::create($myContactGroupFormData);
                                    $group_id = $insertMyContactGroupDetails->id;
                                }

                                //insert into group contact map
                                $myContact = DB::table('contact_list')->select('id')->where('id', '>', $latestMyContactId)->get();

                                foreach($myContact as $myContactValue){
                                    $insertGroupToContact[] = array(
                                        'contact_list_id'=>$myContactValue->id,'contact_group_id'=>$group_id
                                    );
                                }
                                    
                                
                                $insertCGM = ContactGroupMap::insert($insertGroupToContact);

                            }
                            
                        }
                    } else {
                        // return redirect()->back()->with('flash_message_error', 'Your file having unmatched Columns to our database...');
                        return redirect()->route('bulkupload.index')->with('error','Your file having unmatched Columns to our database...');
                    }

                }else if($request->input('bulk_upload_type') == 'member_bulk'){
                    $rolesAdminData = DB::table('roles')->where('orgId',$this->userguard->orgId)->where('role_tag','member')->get();
                    if($countheader == 18  && in_array('email',$headerRow) && in_array('first_name',$headerRow) && in_array('last_name',$headerRow) && in_array('mobile_no',$headerRow)){
                        foreach ($data as $key => $value) {
                            if($value->email && $value->first_name){
                                $randomString = strtolower(str_random(4));
                                $referal_code = substr($value->first_name, 0, 4) . $randomString;
                                $username = strtolower(preg_replace('/[^a-zA-Z0-9\']/', '', substr($value->first_name, 0, 4)). $randomString);


                                $lastUserId = UserMaster::orderBy('id','DESC')->first();
                                $newPersonal_id = str_pad($lastUserId->id + 1, 10, "0", STR_PAD_LEFT);

                                $insert = ['email' => $value->email, 
                                    'first_name' => $value->first_name, 
                                    'last_name' => $value->last_name,
                                    'full_name' => $value->first_name." ".$value->last_name, 
                                    'mobile_no' => $value->mobile_no, 
                                    'orgId' => $this->userguard->orgId, 
                                    'householdName' => $value->first_name."'s household", 
                                    'personal_id' => $newPersonal_id, 
                                    'referal_code' => $referal_code, 
                                    'password' => bcrypt('123456'),
                                    'username' => $username,
                                    'middle_name' => $value->middle_name, 
                                    'nick_name' => $value->nick_name,
                                    'street_address' => $value->street_address,
                                    'apt_address' => $value->apt_address,
                                    'city_address' => $value->city_address,
                                    'state_address' => $value->state_address,
                                    'zip_address' => $value->zip_address,
                                    'gender' => $value->gender,
                                    'birthdate' => $value->birthdate,
                                    'social_profile' => $value->social_profile,
                                    'user_type' => $value->user_type, 
                                    ];
                                 $insertIdUser = User::create($insert);

                                //model has role insert bulk
                                $insertMHRArray[] = ['role_id'=>$rolesAdminData[0]->id,'model_type'=>'App\User','model_id'=>$insertIdUser->id];
                                $arrayUserIds[] = $insertIdUser->id;
                            }                            
                        }
                        // dd($arrayUserIds);
                        // $insertIdUser = User::insert($insert);

                        if(!empty($insertMHRArray)){ 
                            ModelHasRoles::insert($insertMHRArray);
                        }

                        //start of group contact map
                        //insert into group if group name is entered
                        if($request->input('group_id')){
                            $group_id = $request->input('group_id');
                            if($request->input('grp_name_enter')){

                                $myContactGroupFormData = $request->except('bulk_upload_type','group_id','import_file');

                                if($this->userguard->roles[0]->name == "superadmin"){
                                    $myContactGroupFormData['orgId'] = $this->userguard->orgId;
                                }else{
                                    $myContactGroupFormData['orgId'] = $this->userguard->orgId;
                                }
                                $myContactGroupFormData['createdBy'] = $this->userguard->id;

                                $myContactGroupFormData['group_name'] = $request->input('grp_name_enter');
                                
                                $insertMyContactGroupDetails = MyContactGroup::create($myContactGroupFormData);
                                $group_id = $insertMyContactGroupDetails->id;
                            }

                            if($arrayUserIds){
                                foreach($arrayUserIds as $arrayUserIdsVal){
                                    $insertGroupToContact[] = array(
                                        'contact_list_id'   =>  $arrayUserIdsVal,
                                        'contact_group_id'  =>  $group_id,
                                        'createdBy'         =>  $this->userguard->id
                                    );
                                }

                                $insertCGM = ContactGroupMap::insert($insertGroupToContact);

                            }  

                        }

                        //end of group contact map
                        ///////////////////
                         
                        /*
                        //try 3333333333333
                        $bcryptPassword = bcrypt("123456");
                        

                        $connect = new PDO("mysql:host=localhost;dbname=dallas;", "root", "", array(
                            PDO::MYSQL_ATTR_LOCAL_INFILE => true,
                        ));
                        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $total_row = count(file($_FILES['import_file']['tmp_name']));
                        
                        $file_location = str_replace("\\", "/", $_FILES['import_file']['tmp_name']);
                        
                        ///////////persid

                        $query_11 = "
                        SELECT MAX(personal_id) as personal_id FROM users
                        ";
                        
                        $statement = $connect->prepare($query_11);
                        
                        $statement->execute();
                        
                        $result11 = $statement->fetchAll();
                        
                        $personal_id = 0;
                        
                        
                        foreach($result11 as $row)
                        {
                            $personal_id = $row['personal_id'];
                        }
                        // dd($personal_id);
                        $first_personal_id = $personal_id;
                        // 
                        
                        $first_personal_id = str_pad($first_personal_id, 10, "0", STR_PAD_LEFT);
                        // dd($first_personal_id);
                        $query_12 = 'SET @personal_id:='.'"'.str_pad($first_personal_id, 10, "0", STR_PAD_LEFT).'"';
                        // dd('@personal_id:=@personal_id+1');
                        // dd($query_12);
                        $statement = $connect->prepare($query_12);
                        
                        $statement->execute();

                        ////////persid ends
                        $query_1 = '
                        LOAD DATA LOCAL INFILE "'.$file_location.'" IGNORE 
                        INTO TABLE users 
                        FIELDS TERMINATED BY "," 
                        LINES TERMINATED BY "\r\n" 
                        IGNORE 1 LINES 
                        (@column1,@column2,@column3,@column4) 
                        SET email = @column1, first_name = @column2,  last_name = @column3, mobile_no = @column4, 
                            orgId = "'.$this->userguard->orgId.'" ,
                            password = "'.$bcryptPassword.'", householdName = CONCAT(@column2,"","\'s household") ,
                            personal_id = LPAD(@personal_id:=@personal_id+1, 10,0),
                            username = REGEXP_REPLACE(LOWER(CONCAT(SUBSTR(@column2, 1, 4),"",substring(MD5(RAND()),1,6))), "[^[:alnum:]]+", ""),
                            referal_code = REGEXP_REPLACE(LOWER(CONCAT(SUBSTR(@column2, 1, 4),"",substring(MD5(RAND()),1,4))), "[^[:alnum:]]+", ""),
                            full_name = CONCAT(@column2," ",@column3)
                        ';
                        //@personal_id:=@personal_id+1
                        //"'.$first_personal_id.'"
                        $statement = $connect->prepare($query_1);
                        
                        $statement->execute();
                        
                        $query_2 = "
                        SELECT MAX(id) as user_id FROM users
                        ";
                        
                        $statement = $connect->prepare($query_2);
                        
                        $statement->execute();
                        
                        $result = $statement->fetchAll();
                        
                        $user_id = 0;
                        
                        foreach($result as $row)
                        {
                            $user_id = $row['user_id'];
                        }
                        
                        $first_user_id = $user_id - $total_row;
                        
                        $first_user_id = $first_user_id + 1;
                        
                        $query_3 = 'SET @user_id:='.$first_user_id.'';
                        
                        $statement = $connect->prepare($query_3);
                        
                        $statement->execute();
                        

                        //start of group contact map
                        //insert into group if group name is entered
                        if($request->input('group_id')){
                            $group_id = $request->input('group_id');
                            if($request->input('grp_name_enter')){

                                $myContactGroupFormData = $request->except('bulk_upload_type','group_id','import_file');

                                if($this->userguard->roles[0]->name == "superadmin"){
                                    $myContactGroupFormData['orgId'] = $this->userguard->orgId;
                                }else{
                                    $myContactGroupFormData['orgId'] = $this->userguard->orgId;
                                }
                                $myContactGroupFormData['createdBy'] = $this->userguard->id;

                                $myContactGroupFormData['group_name'] = $request->input('grp_name_enter');
                                
                                $insertMyContactGroupDetails = MyContactGroup::create($myContactGroupFormData);
                                $group_id = $insertMyContactGroupDetails->id;
                            }

                            //insert into group contact map
                            $query_5 = '
                            LOAD DATA LOCAL INFILE "'.$file_location.'" IGNORE 
                            INTO TABLE contact_group_map 
                            FIELDS TERMINATED BY "," 
                            LINES TERMINATED BY "\r\n" 
                            IGNORE 1 LINES 
                            (@column1,@column2,@column3,@column4) 
                            SET contact_list_id = @user_id:=@user_id+1, contact_group_id = "'.$group_id.'", 
                            createdBy = "'.$this->userguard->id.'"
                            ';
                            
                            $statement = $connect->prepare($query_5);
                            
                            $statement->execute();    

                        }

                        //end of group contact map


                        $query_22 = "
                        SELECT MAX(id) as user_id FROM users
                        ";
                        
                        $statement = $connect->prepare($query_22);
                        
                        $statement->execute();
                        
                        $result22 = $statement->fetchAll();
                        
                        $user_id = 0;
                        
                        foreach($result22 as $row)
                        {
                            $user_id = $row['user_id'];
                        }
                        
                        $first_user_id = $user_id - $total_row;
                        
                        $first_user_id = $first_user_id + 1;
                        
                        $query_33 = 'SET @user_id:='.$first_user_id.'';
                        
                        $statement = $connect->prepare($query_33);
                        
                        $statement->execute();

                        //start of model has role insert
                        $appuser = "App\\\\\User";
                        $query_4 = '
                        LOAD DATA LOCAL INFILE "'.$file_location.'" IGNORE 
                        INTO TABLE model_has_roles 
                        FIELDS TERMINATED BY "," 
                        LINES TERMINATED BY "\r\n" 
                        IGNORE 1 LINES 
                        (@column1,@column2,@column3,@column4) 
                        SET role_id = "'.$rolesAdminData[0]->id.'", model_type = "'.$appuser.'", model_id = @user_id:=@user_id+1
                        ';
                        
                        $statement = $connect->prepare($query_4);
                        
                        $statement->execute();
                        
                        //end of model has role insert
                        */
                        

                        ////end of try 33333333
                    } else {
                        // return redirect()->back()->with('flash_message_error', 'Your file having unmatched Columns to our database...');
                        return redirect()->route('bulkupload.index')->with('error','Your file having unmatched Columns to our database...');
                    }
                }
                DB::commit();
                return redirect()->route('bulkupload.index')->with('success','Data from file uploaded successfully');
				return redirect('settings/bulkupload');
			}
		}
		return back();
    } 

}