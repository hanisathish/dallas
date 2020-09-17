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
use App\Models\SendSMS;

use Illuminate\Http\Response;
use DataTables;
use Auth;
use App\Helpers\CustomHelperFunctions;
use Twilio;

class SMSController extends Controller {

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
        
        // $response = Twilio::message('+918088231481', 'Church Application Sathish');
        // dd($response);
        
        // $response2 = Twilio::message('+918073991080', 'Church Application Sammy');

        // $response3 = Twilio::message('+17164404733', 'Church Application Meshak');

        // dd($response->sid,$response2->sid,$response3->sid);
        
        $data['title'] = $this->browserTitle . " - SMS Management";

        return view('settings.sms.sms', $data);
    }

    public function list(Request $request){
        
        $orgId = Auth::user()->orgId;
        $userId = Auth::user()->id;
         
        $result = array();  
        
        $whereSMSArray = array('sendsms.orgId'=>$orgId, 'sendsms.sender_user_id'=>$userId);
        $dataObj['groupBy'] = array('sendsms.id');
        $dataObj['orderBy'] = array('sendsms.id'=>'asc');
        
        $selectSendSMSDetail = SendSMS::selectSendSMSDetail($whereSMSArray,null,null,null,null,$dataObj)->get();
        // $selectMyContactDetailresult = $selectSendSMSDetail->toArray();
        // dd($selectMyContactDetailresult);


        $i = 1;
        foreach ($selectSendSMSDetail as $value) {
            
            $row = array();
            $btn = "";
            
            $row[] = $value->receiver_mobile;
            $row[] = substr($value->message, 0, 30);
            $row[] = date('d-M-Y H:i:s',strtotime($value->created_at));
            $row[] = $value->smsstatus;
   
            $result[] = $row;
        }

        return Datatables::of($result)->escapeColumns(['id'])->make(true);
    }

    public function createSMS(Request $request) {
        $data['title'] = $this->browserTitle . " - Create SMS";
        
        
        $whereUMDAdminArray = array('role_tag' => 'admin', 'users.orgId' => $this->userguard->orgId);
        // dd($whereUMDAdminArray);
        $data['selectUserMasterDetail'] = UserMaster::selectUserMasterDetail($whereUMDAdminArray, null, null, null, null, null)->get();
        // dd($selectUserMasterDetail);

        $whereMCGArray = array('contact_group.createdBy'=>Auth::user()->id);
        $dataObj['groupBy'] = array('contact_group.id');
        $dataObj['orderBy'] = array('contact_group.group_name'=>'asc');

        $data['selectMyContactGroupDetail'] = MyContactGroup::selectMyContactGroupDetail($whereMCGArray,null,null,null,null,$dataObj)->get();

        // dd($data['selectMyContactGroupDetail']);
        return view('settings.sms.create_sms', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $insertData = $request->all();
        
        $timestamp = time();
        
        //get sent_from_user user details
        $whereUMDArray = array('users.id'=>Auth::user()->id);
        $selectUserMasterDetail = UserMaster::selectUserMasterDetail($whereUMDArray,null,null,null,null,null)->get()[0];
        
        $to_list='';

         
        $insert_details = array();
        $whereMCGInArray = array('contact_group_map.contact_group_id'=>$request->input('grp_ids'));
        $dataObj['groupBy'] = array('users.id');
        $dataObj['orderBy'] = array('users.id'=>'asc');
        
        $selectMyContactDetail = MyContact::selectMyContactUserDetail(null,$whereMCGInArray,null,null,null,$dataObj)->get();
        $selectMyContactDetailresult = $selectMyContactDetail->toArray();
        

        $message = $request->input('message');
        $sms_sender_id = $request->input('sms_sender_id');
        $routetype = 1;         
        $country = 91;
        // dd($selectMyContactDetail);
        foreach($selectMyContactDetail as $selectMyContactDetailVal){
            if($selectMyContactDetailVal->mobile_no){
                $send_sms = "ss"; //
                if(env('ENABLE_SEND_SMS') == 1){
                    if(env('SMS_GATEWAY') == "TWILIO"){
                        $smsresponse = Twilio::message($selectMyContactDetailVal->mobile_no, $message);
                        $send_sms = $smsresponse->sid;
                    }elseif(env('SMS_GATEWAY') == "SMSCENTRAL"){
                        $dataSMS['receiver_mobile'] = $selectMyContactDetailVal->mobile_no;
                        $dataSMS['message'] = $message;
                        $dataSMS['authKey'] = "105158ADFbjvyivX5f4a766eP1";
                        $dataSMS['sms_sender_id'] = $sms_sender_id;

                        $send_sms = CustomHelperFunctions::sendSMS($dataSMS); //"ss"    
                    }
                    

                    
                }
                
             
                $insert_details = array(
                    'orgId' => Auth::user()->orgId,
                    'routetype' => $routetype,
                    'country' => $country,
                    'sender_mobile' => $selectUserMasterDetail->mobile_no,
                    'receiver_mobile' => $selectMyContactDetailVal->mobile_no,
                    'message' => $message,
                    'sender_user_id' => Auth::user()->id,
                    'receiver_user_id' => $selectMyContactDetailVal->id,
                    'createdBy'=>Auth::user()->id,
                    'output' => $send_sms,
                    'request_id' => $send_sms,
                    'sms_sender_id' => $sms_sender_id,
                );

                SendSMS::create($insert_details);
      
            }
                
            
        }

        
 
        return redirect()->route('sms.create_page')->with('success','SMS Sent Successfully');

        return response()->json(
                        [
                            'success' => '1',
                            "sms" => '<div class="alert alert-success">
                                                                 <strong>Saved!</strong>
                                                           </div>'
                        ]
        );
    }
 

}
