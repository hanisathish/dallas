<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Config;
use DataTables;
use Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use App\Models\Location;
use App\Models\Resources;
use App\Models\Roles;
use App\Models\PaymentMethodOthers;
use App\Models\Organization;
use App\Models\EventAttendance;
use App\Models\UserMaster;
use App\Models\Events;

class EventAttendanceController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->common_file_upload_path = Config::get('constants.FILE_UPLOAD_PATH');
        $this->common_file_download_path = Config::get('constants.FILE_DOWNLOAD_PATH');
        $this->userSessionData = Session::get('userSessionData');
        $this->orgId = $this->userSessionData['umOrgId'];	
        $this->authUserId = $this->userSessionData['umId'];
    }

    public function attendanceIndex() {

        $data['title'] = $this->browserTitle . " - Event Attendance Management";
        return view('attendance.index', $data);
    }

    
    public function getAttendanceList(Request $request){

        //print_r($request);
		//exit();
		print "Eddddd111...............".$request->start_date;
		print "Eddddd111222...............".$request->end_date;
		if($request->start_date != "" && $request->end_date !=""){
		$start_date = date('Y-m-d',strtotime($request->start_date));
		print "Eddddd...............".$start_date;
		
		//dd($request);exit();
		
		//$start_date = "01-09-2020";
		
		$end_date = date('Y-m-d',strtotime($request->end_date));
		print "Ed...............".$end_date;
		}
		//$end_date = "01-13-2020";
				
	    $eventAttendance = EventAttendance::getAttendanceList($start_date, $end_date)->get();
print '<pre>';
print_r($eventAttendance);
exit;		
		//$eventAttendance = EventAttendance::getAttendanceList($start_date = null, $end_date = null);  // For Testing Query
			
	    //$eventAttendance = EventAttendance::getAttendanceList()->get(); 	
	    //$eventAttendance = EventAttendance::getAttendanceList();  // For Testing Query

		//dd($eventAttendance);
        
		$result = array();
		
        $i = 1;
        foreach ($eventAttendance as $event) {
			
            $row = [$i, $event->orgName, $event->eventName, $event->userfullname, $event->gender, $event->attendDate];
			$editLink = url("/attendance/edit/". $event->id);
            $row[] = "<a href='".$editLink ."'>  <i class='fa fa-pencil-square-o'></i></a>";
            $result[] = $row;
            $i += 1;
        }

        return Datatables::of($result)->rawColumns([6])->make(true);
    }

 
    public function createOrEditPage($event_attedance_id = null){
		
			$data['title'] = $this->browserTitle . " - Event Attendance";
			
			$data['event_attedance_id'] =  $event_attedance_id;
					
			$data['orgId'] = $this->userSessionData['umOrgId'];
			
			$wherArray = array('orgId'=> $this->userSessionData['umOrgId']);
			
			$data['user_id'] = UserMaster::crudUserMasterDetail($wherArray,null,null,null,null,null,null,'1')->get();
			
			$whereUEArray=array('orgId'=>$this->orgId);
			
			$eventsData = array();
			
			$crudEvents = Events::crudEvents($whereUEArray,null,null,null,null,null,null,'1')->get();
			
			//dd($crudEvents);
			foreach ($crudEvents as $key=>$crudEventsvalue) {
				if(strtotime($crudEventsvalue->eventCreatedDate) >= strtotime(date('Y-m-d')))
				{
					//dd($crudEventsvalue->eventCreatedDate);$key=>
					$eventsData[] = $crudEventsvalue;
				}
				
			}
		
			$data['upcoming_events']=$eventsData;      
			
			if($event_attedance_id){
				
				$whereSchArray = array('id'=>$event_attedance_id);
				
				$crudEventAttendance = EventAttendance::crudEventAttendance($whereSchArray,null,null,null,null,null,null,'1')->get();
				
				if($crudEventAttendance->count() > 0){
					$data['crudEventAttendance'] = $crudEventAttendance[0];
				}
				else{
					return redirect('attendance');
				}
				
			}
        return view('attendance.create', $data);
    }
	
	
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	 
    public function store(Request $request)
    {
          
		   $insertData = $request->all();
		   
		   $eventattedanceId = $request->eventattedanceId;
		   
           $insertData = $request->except(['eventattedanceId','event_id_hidden','_token']);
		   
		   if($eventattedanceId > 0) { 
            
			    $insertData['updatedBy']= Auth::id();
				
				$insertData['attendance_date'] = date('Y-m-d',strtotime($request->attendance_date));
				
                EventAttendance::where("id",$eventattedanceId)->update($insertData);
			
           } else {
		   
				   $insertData['createdBy'] = Auth::id();
				   
				   $insertData['orgId'] = Auth::user()->orgId;
				   
				   $insertData['attendance_date'] = date('Y-m-d',strtotime($request->attendance_date));
			
				   EventAttendance::create($insertData);
		   }
		   
		   return redirect('attendance');
    }
	
	
	public function editEvent(Request $request, $eventattedanceId) {
		
        $data['title'] = $this->browserTitle . " - ";
		
		$event_attedance = EventAttendance::findOrFail($eventattedanceId);
		
		$data['event_attedance'] = $event_attedance;
		
		$data['orgId'] = $this->userSessionData['umOrgId'];
		
		$wherArray = array('orgId'=> $this->userSessionData['umOrgId']);
			
	    $data['user_id'] = UserMaster::crudUserMasterDetail($wherArray,null,null,null,null,null,null,'1')->get();
		
		$eventsData = array();
		
		$whereUEArray=array('orgId'=>$this->orgId);
	
		$crudEvents = Events::crudEvents($whereUEArray,null,null,null,null,null,null,'1')->get();
		
		//dd($crudEvents);
		foreach ($crudEvents as $key=>$crudEventsvalue) {
			if(strtotime($crudEventsvalue->eventCreatedDate) >= strtotime(date('Y-m-d')))
			{
				$eventsData[] = $crudEventsvalue;
			}
			
		}
		
		$data['upcoming_events']=$eventsData; 

		$whereArray = array('id' => $request->segment(3));
		
		$crudEventAttendance = EventAttendance::getEventAttendanceList($whereArray)->get();
				
		if($crudEventAttendance->count() > 0){
			$data['crudEventAttendance'] = $crudEventAttendance[0];
		}
				
			
        return view('attendance.create',$data);
		
    }

	
}
