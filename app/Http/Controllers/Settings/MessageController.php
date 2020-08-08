<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location;
use DB;
use Config;
use App\Models\Resources;
use App\Models\Roles;
use App\Models\MyContact;
use App\Models\MyContactGroup;
use App\Models\CronBatchEmail;
use App\Models\UserMaster;

use Illuminate\Http\Response;
use DataTables;
use Auth;

class MessageController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->common_file_upload_path = Config::get('constants.FILE_UPLOAD_PATH');
        $this->common_file_download_path = Config::get('constants.FILE_DOWNLOAD_PATH');

        $this->middleware(function ($request, $next) {
            $this->userguard = Auth::guard('web')->user();

            return $next($request);
        });
    }

    public function index() {

        $data['title'] = $this->browserTitle . " - Message Management";

        return view('settings.message.message', $data);
    }

    public function createMessage(Request $request) {
        $data['title'] = $this->browserTitle . " - Create Message";
        
        
        $whereUMDAdminArray = array('role_tag' => 'admin', 'users.orgId' => $this->userguard->orgId);
        // dd($whereUMDAdminArray);
        $data['selectUserMasterDetail'] = UserMaster::selectUserMasterDetail($whereUMDAdminArray, null, null, null, null, null)->get();
        // dd($selectUserMasterDetail);

        $whereMCGArray = array('contact_group.createdBy'=>Auth::user()->id);
        $dataObj['groupBy'] = array('contact_group.id');
        $dataObj['orderBy'] = array('contact_group.group_name'=>'asc');

        $data['selectMyContactGroupDetail'] = MyContactGroup::selectMyContactGroupDetail($whereMCGArray,null,null,null,null,$dataObj)->get();

        // dd($data['selectMyContactGroupDetail']);
        return view('settings.message.create_message', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $insertData = $request->all();
        // $file = $request->file('camp_attach');
        // dd($file);
        //file upload
        $files = "";
        $file_name = "";
        $file_attach = array();
        $original_name = "";
        $timestamp = time();
        $file_details = "";
        $files_offset = array();
        
        //get sent_from_user user details
        $whereUMDArray = array('users.id'=>$request->input('sent_from_user'));
        $selectUserMasterDetail = UserMaster::selectUserMasterDetail($whereUMDArray,null,null,null,null,null)->get()[0];
        if(Input::hasFile('camp_attach')){
            $files_count = count($_FILES['camp_attach']['name']);
        
            for ($i = 0; $i < $files_count; $i++) {
                
               
                    // $file_details = $_FILES['camp_attach']['name'][$i];
                    $file = $request->file('camp_attach')[$i];//$file = $_FILES['camp_attach'];
                    // dd($file);

                    
                    array_push($files_offset, $i);
                    $destinationPath = $this->common_file_upload_path['ORG_UPLOAD_PATH']. DIRECTORY_SEPARATOR . Auth::user()->orgId. DIRECTORY_SEPARATOR . "campaign";

                    \File::makeDirectory($destinationPath, $mode = 0777, true, true);

                    // Check if the uploaded file name consists spaces. If yes, replace with _.
                    

                    // $file_name = $timestamp . "_" . $file_uplod_name;

                    $extension = $file->getClientOriginalExtension();

                    $imageName = basename($file->getClientOriginalName(), ("." . $extension));
                    
                    $imageName = str_replace(",", "_", $imageName);
                    $imageName = str_replace(" ", "_", $imageName);
                    $imageName .= "_" . time() . '.' . $extension;
                    
                    $file_attach[$i] = $destinationPath . '/' . $imageName;
                    
                    $file->move($destinationPath, $imageName);
                
            }
        }
        // dd($file_attach);
        $to_list='';

        $serialize_files_offset = serialize($files_offset);
        $serialize_file_attach = serialize($file_attach);
        

        $getToEmails = explode(",", $to_list);
        $getToEmails = array_map("strtolower", $getToEmails);
        $getToEmails = array_map("trim", $getToEmails);
        $getToEmails = array_filter($getToEmails);
        $getToEmails = array_unique($getToEmails);
        $getToEmails = array_values($getToEmails);
        $total_recepients_count = count($getToEmails);

        $sub = $request->input('camp_subject');

        $msg = $request->input('camp_message');
        $msg .= $msg . "\r\n\n";
        $msg .= "<br><br>Thanks!<br>";
        // $msg .= $usrfullname . "<br>";
        // $msg .= $usremail;
        $whereMCGInArray = array('contact_group_map.contact_group_id'=>$request->input('grp_ids'));
        $dataObj['groupBy'] = array('contact_list.id');
        $dataObj['orderBy'] = array('contact_list.id'=>'asc');
        $selectMyContactDetail = MyContact::selectMyContactDetail(null,$whereMCGInArray,null,null,null,$dataObj)->get();
        // dd($selectMyContactDetail);
        foreach($selectMyContactDetail as $selectMyContactDetailVal){
            
                $insert_details[] = array(
                    'orgId' => Auth::user()->orgId,
                    'subject' => $sub,
                    'message' => $msg,
                    'recipient' => $selectMyContactDetailVal->c_email,
                    // 'cc_recipient' => $cronCcEmails,
                    'files_offset' => $serialize_files_offset,
                    'file_attach' => $serialize_file_attach,
                    'send_status' => 0,
                    'sent_from' => $selectUserMasterDetail->first_name,//Auth::user()->first_name,
                    'sent_from_email' => $selectUserMasterDetail->email,//Auth::user()->email,
                    'send_dts' => date("Y-m-d H:i:s"),
                    'mail_error' => '',
                    'createdBy'=>Auth::user()->id
                    // 'subaccount_id' => $email_subaccount_id
                );


                
            
        }

        CronBatchEmail::insert($insert_details);
 
        return redirect()->route('message.create_page')->with('success','Message Sent Successfully');

        return response()->json(
                        [
                            'success' => '1',
                            "message" => '<div class="alert alert-success">
                                                                 <strong>Saved!</strong>
                                                           </div>'
                        ]
        );
    }

    public function resourceList(Request $request) {
        $resources = Resources::listResources($request->search['value']);

        return DataTables::of($resources)
                        ->addColumn('action', function($row) {
                            $btn = '<a onclick="editResource(' . $row->id . ')"  class="edit btn btn-primary btn-sm ">Edit</a>';


                            return $btn;
                        })

                        ->addColumn('image', function($row) {
                            $hh_pic_image= url('/assets/uploads/organizations/avatar.png');
                            if($row->item_photo != null){
                                $hh_pic_image_json = json_decode(unserialize($row->item_photo));
                                $hh_pic_image = $hh_pic_image_json->download_path.$hh_pic_image_json->uploaded_file_name;
                            }
                            return "<img src='$hh_pic_image' style='max-width:25px;' />";
                        })
                        ->rawColumns(['action','image'])
                        ->make(true);
    }

    public function edit($id) {
        $data['title'] = $this->browserTitle . " - Create Event";
        $data['category'] = \App\Models\MasterLookupData::selectFromMasterLookupData([["mldKey","=","resource_category"]])->get();
        $data['roles'] = Roles::selectFromRoles(['orgId'=>Auth::user()->orgId])->get();
        $resources = Resources::findOrFail($id);
        $data['locations'] = Location::listLocations("")->get();
        $data['resource'] = $resources;
        return view('message.create_resource', $data);
    }

    /**
     * @Function name : resourceFileUpload
     * @Purpose : upload resourceFileUpload
     * @Added by : Ananth
     * @Added Date : 1 sep 2019
     */
    private function resourceFileUpload($file) {


        $extension = $file->getClientOriginalExtension();


        $imageName = basename($file->getClientOriginalName(), ("." . $extension));

        $imageName .= "_" . time() . '.' . $extension;
        $destinationPath = $this->common_file_upload_path['PROFILE_PIC_UPLOAD_PATH'] . DIRECTORY_SEPARATOR . Auth::user()->orgId . DIRECTORY_SEPARATOR . "resource" . DIRECTORY_SEPARATOR;


        $downloadPath = $this->common_file_download_path['PROFILE_PIC_DOWNLOAD_PATH'] . '/' . Auth::user()->orgId . '/' . "resource" . '/';


        $file->move(
                $destinationPath, $imageName
        );



        $upload_data = array('uploaded_path' => $destinationPath, 'download_path' => $downloadPath, 'uploaded_file_name' => $imageName, 'original_filename' => $imageName, 'upload_file_extension' => $extension, 'file_size' => 0);
        $jsonformat = serialize(json_encode($upload_data));

        return $jsonformat;
    }

}
