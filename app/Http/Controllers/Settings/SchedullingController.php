<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Config;
use yajra\Datatables\Datatables;
use App\Helpers\CommunicationHelper;

use App\Models\Schedule;
use App\Models\Events;
use App\Models\MasterLookupData;
use App\Models\SchedulingUser;
use App\Models\CommTemplate;
use App\Models\Team;
use App\User;

class SchedullingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->userSessionData = Session::get('userSessionData');
        $this->orgId = $this->userSessionData['umOrgId'];
        $this->authUserId = $this->userSessionData['umId'];
    }

    public function schedullingIndex(){
        $data['title'] = $this->browserTitle . " - Schedule List";
        return view('settings.schedule.index', $data);
    }

    public function getScheduleList(){
        $result = array();
        $schedules = Schedule::where('orgId', $this->orgId)->with(["event"=>function($query){
                        $query->select('eventId', 'eventName');
                    }, "volunteer"=>function($query1){
                        $query1->select('mldId', 'mldValue');
                    }])->select("id", "event_id", "title")->orderBy("id", "desc")->get();
        
        $i = 1;
        foreach ($schedules as $schedule) {
            $row = [$i, $schedule->title,  $schedule->event->eventName];
            //\Carbon\Carbon::parse($schedule->time)->format('h:i'), \Carbon\Carbon::parse($schedule->date)->format('d-m-Y')
            $viewLink = "";//<a href='".url("/settings/schedulling/". $schedule->id) ."'><i class='fa fa-eye'></i></a>
            $editLink = url("/settings/schedulling/manage/". $schedule->id);
            $row[] = "<a href='".$editLink ."'>  <i class='fa fa-pencil-square-o'></i></a>";
            $result[] = $row;
            $i += 1;
        }

        return Datatables::of($result)->rawColumns([3])->make(true);
    }

    public function schedullingDetails($schedule_id){
        $data['title'] = $this->browserTitle . " - Schedule List";
        
        $schedule = Schedule::where('orgId', $this->orgId)->where("id", $schedule_id)
                            ->with(["event"=>function($query){
                                $query->select('eventId', 'eventName');
                            }, "volunteer"=>function($query1){
                                $query1->select('mldId', 'mldValue');
                            }])->first();
        $memberIds = unserialize($schedule->assign_ids);
        if(isset($memberIds) && count($memberIds) > 0){
            $schedule["members"] = User::whereIn("id", $memberIds)->select("id", "profile_pic", "email", "full_name", "mobile_no")->get();
        }else{
            $schedule["members"] = [];
        }
        $data["schedule"] = $schedule;
        return view('settings.schedule.details', $data);
    }
    
    public function createOrEditPage($schedule_id = null){
        $data['title'] = $this->browserTitle . " - Schedule List";
        $data['schedule_id'] =  $schedule_id;
        $whereTeamArray=array('orgId'=>$this->orgId);
        $data['team_id'] = Team::selectFromTeam($whereTeamArray)->get();

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
        //dd(count($eventsData));
        $data['upcoming_events']=$eventsData;
        //dd($data['team_id']->get()->toArray(),$whereTeamArray);
        
        if($schedule_id){
            $whereSchArray = array('id'=>$schedule_id);
            $crudSchedule = Schedule::crudSchedule($whereSchArray,null,null,null,null,null,null,'1')->get();
            //$data['crudSchedule'] = $crudSchedule;
            if($crudSchedule->count() > 0){
                $data['crudSchedule'] = $crudSchedule[0];
            }else{
                return redirect('settings/schedulling');
            }
            
        }
        //dd($data['crudSchedule']->count());
        return view('settings.schedule.create', $data);
    }

    public function notificationList(){
        $data['title'] = $this->browserTitle . " - Schedule Notifications List";
        return view('settings.schedule.notification', $data);
    }

    public function storeOrUpdateSchedule(Request $request){
        $payload = $request->all();
        //dd($payload);
        //dd($arraySUUpdate,$request->all());
        $schedule = null;
        $isNewSchedule = true;
        if(isset($payload['scheduleId'])){
            $schedule = Schedule::where("id", $payload["scheduleId"])->first();
            $isNewSchedule = false;
        }else{
            $schedule = new Schedule();
            $schedule->orgId = $this->orgId;
        } 
        //dd($schedule);
        // return $payload;
        $fields = ['title', 'event_id', 'is_manual_schedule', 'notification_flag', 'team_id', 'event_date'];
        foreach($fields as $field){
            $schedule[$field] = $payload[$field];
        }
        //dd($schedule);
        //$schedule->assign_ids = serialize($payload["assign_ids"]);
        $schedule->save();
        if($request->get('position_id_assign') != null || $request->get('position_id_assign') != ""){
            foreach($request->get('position_id_assign') as $posids){

                $arraySUUpdate = array("orgId"=>$this->orgId,"scheduling_id"=>$schedule->id,"team_id"=>$request->get('team_id'),"position_id"=>$posids,"user_id"=>$request->get('position_id_user_id_assign_'.$posids),"status"=>1);

                SchedulingUser::updateOrCreate(array("orgId"=>$this->orgId,"scheduling_id"=>$schedule->id,"team_id"=>$request->get('team_id'),"position_id"=>$posids), $arraySUUpdate);
                //echo $posids;,"user_id"=>$request->get('position_id_user_id_assign_'.$posids)
            }    
        }
        

        //$this->generateCommunication($this->orgId, $this->authUserId, $payload["assign_ids"], $schedule, $isNewSchedule);
        return redirect('settings/schedulling/');
        return ["message"=> "Schedule has been successfully stored or updated"];
    }

    public function getNotificationsList($template_id = null){
        $notificationTags = ["schedule_auto_notify", "schedule_manual_notify", "schedule_confirmation", "schedule_reminder", "schedule_check_out_notification_to_guest", "thank_you_for_service", "schedule_cancelled"];
        $templates = [];
        if(isset($template_id)){
            $templates = CommTemplate::where('org_id', $this->orgId)
                            ->where("id", $template_id)
                            ->select("id", "tag", "name", "subject", "body")->first();
        }else {
            $templates = CommTemplate::where('org_id', $this->orgId)
                            ->whereIn("tag", $notificationTags)
                            ->select("id", "tag", "name", "subject")->get();
            if(count($templates) < count($notificationTags)){
                $templates = $this->generateNotificationTemplates($this->orgId, $notificationTags);
            }
        }
        return $templates;
    }

    public function createRelatedData(Request $request){
        $payload = json_decode(request()->getContent(), true);
        $schedule = [];
        if(isset($payload["scheduleId"])){
            $schedule = Schedule::where('orgId', $this->orgId)->where("id", $payload["scheduleId"])->first();
            if(isset($schedule->assign_ids)){
                $schedule->assign_ids = unserialize($schedule->assign_ids);
            }
        }
        $volunteer_types = MasterLookupData::where("mldKey", "type_of_volunteer")->where('orgId', $this->orgId)->select("mldId", 'mldKey', 'mldValue')->get();
        if(count($volunteer_types) <= 0){
            $volunteer_types = $this->generateVolunteerTypes($this->orgId);
        } 
        $events = Events::where('orgId', $this->orgId)->select("eventId", 'eventName')->get();
        return ["schedule"=>$schedule, "volunteer_types"=>$volunteer_types, "events"=>$events];
    }

    public function getAssignedMembersList(Request $request){
        $payload = json_decode(request()->getContent(), true);
        $users = User::whereIn('id', $payload["assign_ids"])->select("id", "full_name", "profile_pic", "email")->get();

        return $users;
    }

    public function getMemberSearchList(Request $request){
        $payload = json_decode(request()->getContent(), true);
        $users = User::where('orgId', $this->orgId)
                    ->whereNotIn('id', $payload["exceptIds"])
                    ->where('full_name', 'LIKE', "%" . $payload['searchStr'] . "%")
                    ->orWhere("email", $payload['searchStr'])
                    ->orWhere("mobile_no",$payload['searchStr'])
                    ->select('id', "full_name", 'email', 'profile_pic')
                    ->get();
        return $users;
    }

    static function generateVolunteerTypes($orgId){
        $data = array(
            array('orgId'=>$orgId, 'mldKey'=> "type_of_volunteer", "mldValue"=>"checker"),
            array('orgId'=>$orgId, 'mldKey'=> "type_of_volunteer", "mldValue"=>"service"),
            array('orgId'=>$orgId, 'mldKey'=> "type_of_volunteer", "mldValue"=>"helper")
        );
        MasterLookupData::insert($data);
        return MasterLookupData::where("mldKey", "type_of_volunteer")->where('orgId', $orgId)->select("mldId", 'mldKey', 'mldValue')->get();
    }

    static function generateCommunication($orgId, $createdUserId, $userIds, $schedule, $isNewSchedule = true){  
        if($isNewSchedule == true){
            CommunicationHelper::generateCommunications('schedule_manual_notify', $orgId, 1, $createdUserId, $userIds, $schedule->id);
        }else {
            
            $existingUserIds = SchedulingUser::where("scheduling_id", $schedule->id)->pluck('user_id')->toArray();
            $removedUserIds = array_diff($existingUserIds, $userIds);
            $newUserIds = array_diff($userIds, $existingUserIds);
            $inserRecords = [];
            foreach($newUserIds as $userId){
                $record = [];
                $record["orgId"] = $orgId;
                $record["scheduling_id"] = $schedule->id;
                $record["user_id"] = $userId;
                $record["token"] = substr(sha1(time()), 0, 150).rand ( 199999999, 9999999999999999 );

                $inserRecords[] = $record;
            }
            SchedulingUser::insert($inserRecords);
            SchedulingUser::where("scheduling_id", $schedule->id)->whereIn('user_id', $removedUserIds)->delete();
            CommunicationHelper::generateCommunications('schedule_manual_notify', $orgId, 1, $createdUserId, $newUserIds, $schedule->id);
            CommunicationHelper::generateCommunications('schedule_canceled', $orgId, 1, $createdUserId, $removedUserIds, $schedule->id);
        }
    }

    static function generateNotificationTemplates($orgId, $tags){
        foreach($tags as $tag){
            $template = CommTemplate::where("org_id", $orgId)->where("tag", $tag)->first();
            if(!isset($template)){
            $defaultTemplate = CommTemplate::where('tag', $tag)->where('org_id', 0)->first();
            CommTemplate::create([
                                'tag' => $defaultTemplate->tag,
                                'name' => $defaultTemplate->name,
                                'subject' => $defaultTemplate->subject,
                                'body' => $defaultTemplate->body,
                                'org_id' => $orgId
                            ]);
            }
        }
        $templates = CommTemplate::where("org_id", $orgId)->whereIn("tag", $tags)->select("id", "tag", "name", "subject")->get();
        dd($templates);
        exit;
    }
}

