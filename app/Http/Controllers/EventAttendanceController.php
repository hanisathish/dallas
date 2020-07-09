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
use App\Models\AttendanceCount;

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
		
		$whereUEArray=array('orgId'=>$this->orgId);		
		$data['crudEvents'] =  $crudEvents = Events::crudEvents($whereUEArray,null,null,null,null,null,null,'1')->get();
		
        return view('attendance.index', $data);
    }

    
    public function getAttendanceList(Request $request){

        $result = array();
		
		if(isset($request->start_date) && isset($request->end_date)) {
			
		  $start_date = date('Y-m-d',strtotime($request->start_date));
		  $end_date = date('Y-m-d',strtotime($request->end_date));
		  
		}
		else
		{
			$start_date ="";
			$end_date ="";
		}
		
		if(isset($request->event_id)){
			
			$event_id = $request->event_id;
		}
		else {
			 
			$event_id = "";
			
		}
		//dd($this->orgId);
	      $eventAttendance = EventAttendance::getAttendanceList($start_date, $end_date, $event_id, $this->orgId)->get();		
		//$eventAttendance = EventAttendance::getAttendanceList($start_date, $end_date, $event_id);  // For Testing Query
			
		//dd($eventAttendance);
        			
        $i = 1;
        foreach ($eventAttendance as $event) {
			
            $row = [$i, $event->orgName, $event->eventName, $event->userfullname, $event->gender, $event->attendDate];
			$editLink = url("/attendance/edit/". $event->id);
            $row[] = '<a href='.$editLink.'> <i class="fa fa-pencil-square-o"></i></a> <a onclick="attendance_data_delete('.$event->id.')"> <i class="fa fa-trash"></i></a>';
							
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
	
	
	public function deleteEventAttendanceById(Request $request)
    {

        $whereArray = array('id' => $request->get('eventattedanceId'));
        $updateAHDeletedStatus = array('deleted_at' => now(), 'deletedBy' => $this->authUserId);
        EventAttendance::crudEventAttendance($whereArray, null, null, null, null, $updateAHDeletedStatus, null, null);
    }
	
	
	
	public function eventattendanceIndex()
    {
        $data['title'] = $this->browserTitle . " - Event Attendance List";
		
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

        return view('eventattendance.index', $data);
    }
	
	
	public function getEventAttendanceCountList()
    {
        $result = array();  
		
		$orgId = Auth::user()->orgId;
		
        $eventattendance = AttendanceCount::selectEventAttendanceCountList($orgId)->get();

        $i = 1;
        foreach ($eventattendance as $event) {
			
            $row = array();
			
            $row[] = $event->id;
			$row[] = $event->eventName;
            $row[] = $event->orgName;
            $row[] = $event->male_count;
            $row[] = $event->female_count;

            //showConfirm
            $button_html = '<a onclick="edit_attendance_count(' . $event->id . ')"  data-toggle="tooltip"   href="#"  data-original-title="Edit"><i class="fa fa-edit"></i></a>
                            <a onclick="attendance_count_data_delete(' . $event->id . ')"   href="#"><i class="fa fa-trash"></i></a>';

            $row[] = $button_html;
            $result[] = $row;
        }

        //return Datatables::of($result)->rawColumns([6])->make(true);
        return Datatables::of($result)->escapeColumns(['id'])->make(true);
    }
	
	
	public function getAttendanceCountById(Request $request)
    {
        $getAttendanceCountById = AttendanceCount::find($request->get('attendanceCountID'));
        return $getAttendanceCountById;
    }
	
	
	public function storeOrUpdateAttendanceCount(Request $request)
    {
		
        $insightFormData = $request->all();
		
		
		
        $insightFormData = $request->except('hidden_attendanceCountID');
		
        $insightFormData['createdBy'] = $this->authUserId;

        unset($insightFormData['hidden_attendanceCountID'], $insightFormData['_token'], $insightFormData['event_id_hidden']);
		
		$whereSchArray = array('id'=>$request->get('hidden_attendanceCountID'));
		
		$crudAttendanceCount = AttendanceCount::crudAttendanceCount($whereSchArray,null,null,null,null,null,null,'1')->get();
		
		if($crudAttendanceCount->count() > 0){
			$data['crudAttendanceCount'] = $crudAttendanceCount[0];
		}
		


        $insightFormData['orgId'] = Auth::user()->orgId;
        
        $whereACArray = array('orgId' => $insightFormData['orgId'], 'event_id' => $insightFormData['event_id'], 'event_date'=> $insightFormData['event_date']);
				
	    $arrayACUpdate = array('orgId' => $insightFormData['orgId'], 'event_id' => $insightFormData['event_id'], 'event_date'=> $insightFormData['event_date'],
		'male_count' => $insightFormData['male_count'],'female_count' => $insightFormData['female_count']);
				
        $updateCreateDetails = AttendanceCount::updateOrCreate($whereACArray, $arrayACUpdate);
		return "updated";
		
		
        /*if ($request->get('hidden_attendanceCountID') > 0) {
            unset($insightFormData['createdBy']);
            $insightFormData['updatedBy'] = $this->authUserId;
            $whereArray = array('id' => $request->get('hidden_attendanceCountID'));
            $updateDetails = AttendanceCount::updateAttendanceCount($insightFormData, $whereArray);
            return "updated";
        } else {
			
			$insightFormData['orgId'] = Auth::user()->orgId;
            $insertDetails = AttendanceCount::create($insightFormData);
            if ($insertDetails->id > 0) {
                return "inserted";
            } else {
                return 0;
            }
        }*/
		
		
    }
	
	public function deleteAttendanceCountById(Request $request)
    {

        $whereArray = array('id' => $request->get('attendanceCountId'));
        $updateAHDeletedStatus = array('deleted_at' => now(), 'deletedBy' => $this->authUserId);
        AttendanceCount::crudAttendanceCount($whereArray, null, null, null, null, $updateAHDeletedStatus, null, null);
    }
	
		
}
