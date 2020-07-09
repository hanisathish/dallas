<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use Config;
use App\Models\Events;
use App\Models\Checkins;
use DataTables;
use Auth;
class CheckinController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
    }
    public function index($eventId=0)
    {
        $data['title'] = $this->browserTitle . " - Checkin Management";
		
		if($eventId > 0) {
			$eventDetails = Events::getEventsDetails($eventId);
			$data['eventDetails'] = $eventDetails;
		}
        
        return view('checkin.index',$data);
    }
    
    
    public function logCheckin(Request $request) {
        
        $insertData = array(
            "eventId"=>$request->eventId,
            "user_id"=>$request->userId,
            "chINDateTime"=>date("Y-m-d h:i:s"),
            "chKind"=>1,
            "createdBy"=> Auth::id()
        );
        
        Checkins::create($insertData);
        //print_r($request->all());
    }
    
     public function logCheckout(Request $request) {
        
        $updatetData = array(
            "chOUTDateTime"=>date("Y-m-d h:i:s"),
            "updatedBy"=> Auth::id()
        );
        
        Checkins::where("chId",$request->chId)->update($updatetData);
        //print_r($request->all());
    }
    
     public function checkInList(Request $request) {
         
         $data = array(
             "eventId"=>$request->eventId,
             "searchText" =>$request->search['value']
         );
         $events = Checkins::listCheckins($data);
        
        return DataTables::of($events)
                    
                    ->addColumn('checkInUser', function($events){
                        
                        $userImg = url('assets/uploads/profile').'/user.jpg';
                        
                        $profilePic = $events->profile_pic;
                        if($profilePic != null){
                            $hh_pic_image_json = json_decode(unserialize($profilePic));
                            $userImg = $hh_pic_image_json->download_path.$hh_pic_image_json->uploaded_file_name;
                        }
                        
                           $btn = '<div class="row checkin-user">

                                 
                                    <div class=" col-md-1 image-container">
                                      <img src="'.$userImg.'" class="checkin-user-img" style="height:50px; " />
                                    </div>

                                    <div class=" col-md-8 ">  

                                      <div class="checkin-user-name">'.$events->first_name."".$events->last_name.'</div>
                                       <div class="checkin-user-details"> '.$events->chKind.'
                                       <span>@'.date('h:i A', strtotime($events->chINDateTime)).'</span>';
                                           
                                        if($events->life_stage=="Child"){
                                            $btn.='<span><a   href="javascript:printCard('.$events->eventId.','.$events->user_id.','.$events->chId.')">Print</a></span>';
                                        }
                           
                                         $btn.='</div>
                                    </div>';
                                    if($events->chOUTDateTime == "" ||  $events->chOUTDateTime =="NULL"){
                                        
                                        $btn.=' <div class="col-md-3">  
                                                    <button class="btn" onclick="checkOutUser('.$events->chId.','.$events->eventId.','.$events->user_id.')">Check Out</button>
                                                </div>';
                                    }
                                    else {
                                        $btn.=' <div class="col-md-3 ">  
                                                    <span>@'.date('h:i A', strtotime($events->chOUTDateTime)).'</span>
                                                </div>';
                                    }
                                   
                                    
                                    $btn.= '</div>
                                    
                       </div>';
     
                            return $btn;
                    })
                    ->rawColumns(['checkInUser'])
                    ->make(true);
     }
    
     
     public function getChildProfile(Request $request){
         //print_r("sdsd"); exit();
         $eventId = $request->eventId;
         $userId = $request->userId;
         $checkinId = $request->checkinId;
         if($eventId > 0 && $userId > 0 ) {
			$profileDetails = Checkins::getChildProfileDetails($eventId,$userId,$checkinId);
                        
                        $userImg = url('assets/uploads/profile').'/user.jpg';
                        $qr_code = url('assets/theme/images').'/qrcode.png';
                                
                        $profilePic = $profileDetails->profile_pic;
                        if($profilePic != null){
                            $hh_pic_image_json = json_decode(unserialize($profilePic));
                            $userImg = $hh_pic_image_json->download_path.$hh_pic_image_json->uploaded_file_name;
                            
                        }
                        $profileDetails->user_image= $userImg;
                        $profileDetails->qr_code= $qr_code;
                        $profileDetails->full_name= $profileDetails->first_name."".$profileDetails->last_name;
                       
			$data['profileDetails'] = $profileDetails;
                        
                         return view('checkin.child_profile_print',$data);
		}
        
       
     }




     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')
            ->with('success',
             'Role deleted successfully!');
    }

    /**
     * @Function name : adultCheckin
     * @Purpose : adultCheckin
     * @Added by : Sathish
     * @Added Date : Jun 12, 2019
     */
    public function adultCheckin(Request $request) {        
        $data['title'] = $this->browserTitle . " - Adult Checkin";        
        return view('checkin.adult',$data);
    }

    /**
     * @Function name : childCheckin
     * @Purpose : childCheckin
     * @Added by : Sathish
     * @Added Date : Jun 12, 2019
     */
    public function childCheckin(Request $request) {        
        $data['title'] = $this->browserTitle . " - Child Checkin";        
        return view('checkin.child',$data);
    }

    /**
     * @Function name : notificationCheckin
     * @Purpose : notificationCheckin
     * @Added by : Sathish
     * @Added Date : Jun 12, 2019
     */
    public function notificationCheckin(Request $request) {        
        $data['title'] = $this->browserTitle . " - Notification Checkin";        
        return view('checkin.notification',$data);
    }

    /**
     * @Function name : reportCheckin
     * @Purpose : reportCheckin
     * @Added by : Sathish
     * @Added Date : Jun 12, 2019
     */
    public function reportCheckin(Request $request) {        
        $data['title'] = $this->browserTitle . " - Report Checkin";        
        return view('checkin.report',$data);
    }
}