<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Config;
use yajra\Datatables\Datatables;
use App\Helpers\CommunicationHelper;

use App\Models\Team;
use App\Models\TeamHasPosition;
use App\Models\Events;
use App\Models\MasterLookupData;
use App\Models\SchedulingUser;
use App\Models\CommTemplate;
use App\Models\Position;
use App\User;
use DB;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->userSessionData = Session::get('userSessionData');
        $this->orgId = $this->userSessionData['umOrgId'];
        $this->authUserId = $this->userSessionData['umId'];
    }

    public function teamIndex()
    {
        $data['title'] = $this->browserTitle . " - team List";

        $wherePosArray = array('orgId' => $this->orgId);
        $data['selectFromPosition'] = Position::selectFromPosition($wherePosArray)->get();
        //dd($data['selectFromPosition']);

        return view('settings.team.index', $data);
    }

    public function getTeamList()
    {
        $result = array();
        $whereArray = array('orgId' => $this->orgId);
        $teams = Team::selectTeamDetail($whereArray, null, null, null, null, null)->get();

        $i = 1;
        foreach ($teams as $team) {
            $row = array();

            $row[] = $team->id;
            $row[] = $team->name;
            //showConfirm
            $button_html = '<a  onclick="edit_team(' . $team->id . ')"  data-toggle="tooltip"   href="#"  data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                <a onclick="team_data_delete(' . $team->id . ')"   href="#"><i class="fa fa-trash"></i></a>';

            $row[] = $button_html;
            $result[] = $row;
        }

        //return Datatables::of($result)->rawColumns([6])->make(true);
        return Datatables::of($result)->escapeColumns(['id'])->make(true);
    }

    /**
     * @Function name : getTeamById
     * @Purpose : Select from Team by ID
     * @Added by : Sathish
     * @Added Date : Nov 07, 2018
     */
    public function getTeamById(Request $request)
    {
        $getTeamById = Team::find($request->get('teamID'));

        $whereTHPArray = array('team_id' => $request->get('teamID'));
        $selectFromTeamHasPosition = TeamHasPosition::selectFromTeamHasPosition($whereTHPArray)->get();

        $selPosIds='';
        if($selectFromTeamHasPosition->count() > 0){
            $selPosIds = implode(",", array_column($selectFromTeamHasPosition->toArray(), 'position_id')); 
        }        
        //"[". ."]"
        return response()->json(['teamData' => $getTeamById, 'teamPos' => $selPosIds], 200);

        return $getTeamById;
    }

    public function storeOrUpdateTeam(Request $request)
    {
        $TeamFormData = $request->except('hidden_teamID','team_pos_id');//
        $TeamFormData['createdBy'] = $this->authUserId;
        $TeamFormData['orgId'] = $this->orgId;
        unset($TeamFormData['hidden_teamID'], $TeamFormData['_token']);
        if ($request->get('hidden_teamID') > 0) {
            unset($TeamFormData['createdBy']);
            $TeamFormData['updatedBy'] = $this->authUserId;
            //dd($TeamFormData);
            $whereArray = array('id' => $request->get('hidden_teamID'));
            $updateDetails = Team::updateTeam($TeamFormData, $whereArray);

             //$request['team_pos_id']= $request->get('team_pos_id');
            // $request['hidden_teamID']= $request->get('hidden_teamID');
            
            $this->storeOrUpdateTeamHasPos($request);
            return "updated";
        } else {
            $insertDetails = Team::create($TeamFormData);
            if ($insertDetails->id > 0) {
                $request['team_pos_id']= $request->get('team_pos_id');//$request->team_pos_id;
                $request['hidden_teamID']= $insertDetails->id;
                
                $this->storeOrUpdateTeamHasPos($request);

                return "inserted";
            } else {
                return 0;
            }
        }

    }

    /**
     * @Function name : deleteTeamById
     * @Purpose : Delete from Team
     * @Added by : Sathish
     * @Added Date : Nov 07, 2018
     */
    public function deleteTeamById(Request $request)
    {

        $whereArray = array('id' => $request->get('teamId'));
        $updateAHDeletedStatus = array('deleted_at' => now(), 'deletedBy' => $this->authUserId);
        Team::crudTeam($whereArray, null, null, null, null, $updateAHDeletedStatus, null, null);
    }

    /**
     * @Function name : storeOrUpdateTeamHasPos
     * @Purpose : Delete from Team
     * @Added by : Sathish
     * @Added Date : Nov 07, 2018
     */
    public function storeOrUpdateTeamHasPos(Request $request)
    { 
        //DB::beginTransaction();

        //try {
            $team_pos_id = $request->team_pos_id;
            $team_id = $request->hidden_teamID;
            
            //dd(array_values($team_pos_id));
            $exp_team_pos_id = explode(",", implode(",",$team_pos_id));//explode(",", $team_pos_id);
            //$exp_team_pos_id = explode(",", $exp_team_pos_id);
            //dd($team_pos_id,$exp_team_pos_id);
            //First update not in to null(deleted)
            $whereNotInUHPUpdArray = array('team_id' => $exp_team_pos_id);
            $update_details_uhp = array('deleted_at' => now(), 'deletedBy' => $this->authUserId);
            $whereUHPUpdArray = array('team_id' => $team_id);

            TeamHasPosition::crudTeamHasPosition($whereUHPUpdArray, null, $whereNotInUHPUpdArray, null, null, $update_details_uhp, null, null);

            //Insert or update
            foreach ($exp_team_pos_id as $exp_team_pos_id_value) {
                $whereTHPArray = array('team_id' => $request->team_id, 'position_id' => $exp_team_pos_id_value);

                $arrayUHPUpdate = array('createdBy' => $this->authUserId, 'team_id' => $request->hidden_teamID, 'position_id' => $exp_team_pos_id_value);
                TeamHasPosition::updateOrCreate($whereTHPArray, $arrayUHPUpdate);
            }
            /*
            DB::commit();
            return response()->json(['result_code' => 1, 'message' => 'Team Updated Successfully.'], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json(['result_code' => 0, 'message' => "Sorry , Changes not updated. Please try again!!!!!"], 200);//$e->getMessage()
            // something went wrong with the transaction, rollback
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['result_code' => 0, 'message' => "Sorry , Changes not updated. Please try again!!!!!"], 200);
            return Redirect::back()->withErrors($e->getMessage());
        }
        */
        //return ($request->all());
    }
}
