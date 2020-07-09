<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Config;
use yajra\Datatables\Datatables;
use App\Helpers\CommunicationHelper;

use App\Models\Position;
use App\Models\UserHasPosition;
use App\Models\Events;
use App\Models\MasterLookupData;
use App\Models\SchedulingUser;
use App\Models\CommTemplate;
use App\User;
use DB;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->userSessionData = Session::get('userSessionData');
        $this->orgId = $this->userSessionData['umOrgId'];
        $this->authUserId = $this->userSessionData['umId'];
    }

    public function positionIndex()
    {
        $data['title'] = $this->browserTitle . " - position List";
        return view('settings.position.index', $data);
    }

    public function getPositionList()
    {
        $result = array();
        $whereArray = array('orgId' => $this->orgId);
        $positions = Position::selectPositionDetail($whereArray, null, null, null, null, null)->get();

        $i = 1;
        foreach ($positions as $position) {
            $row = array();

            $row[] = $position->id;
            $row[] = $position->name;
            //showConfirm
            $button_html = '<a  onclick="edit_position(' . $position->id . ')"  data-toggle="tooltip"   href="#"  data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                <a onclick="position_data_delete(' . $position->id . ')"   href="#"><i class="fa fa-trash"></i></a>';

            $row[] = $button_html;
            $result[] = $row;
        }

        //return Datatables::of($result)->rawColumns([6])->make(true);
        return Datatables::of($result)->escapeColumns(['id'])->make(true);
    }

    /**
     * @Function name : getPositionById
     * @Purpose : Select from Position by ID
     * @Added by : Sathish
     * @Added Date : Nov 07, 2018
     */
    public function getPositionById(Request $request)
    {
        $getPositionById = Position::find($request->get('positionID'));
        return $getPositionById;
    }

    public function storeOrUpdatePosition(Request $request)
    {
        $PositionFormData = $request->except('hidden_positionID');
        $PositionFormData['createdBy'] = $this->authUserId;
        $PositionFormData['orgId'] = $this->orgId;
        unset($PositionFormData['hidden_positionID'], $PositionFormData['_token']);
        if ($request->get('hidden_positionID') > 0) {
            unset($PositionFormData['createdBy']);
            $PositionFormData['updatedBy'] = $this->authUserId;
            $whereArray = array('id' => $request->get('hidden_positionID'));
            $updateDetails = Position::updatePosition($PositionFormData, $whereArray);
            return "updated";
        } else {
            $insertDetails = Position::create($PositionFormData);
            if ($insertDetails->id > 0) {
                return "inserted";
            } else {
                return 0;
            }
        }
    }

    /**
     * @Function name : deletePositionById
     * @Purpose : Delete from Position
     * @Added by : Sathish
     * @Added Date : Nov 07, 2018
     */
    public function deletePositionById(Request $request)
    {

        $whereArray = array('id' => $request->get('positionId'));
        $updateAHDeletedStatus = array('deleted_at' => now(), 'deletedBy' => $this->authUserId);
        Position::crudPosition($whereArray, null, null, null, null, $updateAHDeletedStatus, null, null);
    }

    /**
     * @Function name : storeOrUpdateUserHasPos
     * @Purpose : Delete from Position
     * @Added by : Sathish
     * @Added Date : Nov 07, 2018
     */
    public function storeOrUpdateUserHasPos(Request $request)
    {

        DB::beginTransaction();

        try {
            $user_pos_id = $request->user_pos_id;
            $user_id = $request->user_id;

            $exp_user_pos_id = explode(",", $user_pos_id);
            //dd($exp_user_pos_id);
            //First update not in to null(deleted)
            $whereNotInUHPUpdArray = array('position_id' => $exp_user_pos_id);
            $update_details_uhp = array('deleted_at' => now(), 'deletedBy' => $this->authUserId);
            $whereUHPUpdArray = array('user_id' => $user_id);
            UserHasPosition::crudUserHasPosition($whereUHPUpdArray, null, $whereNotInUHPUpdArray, null, null, $update_details_uhp, null, null);

            //Insert or update
            foreach ($exp_user_pos_id as $exp_user_pos_id_value) {
                $whereUHPArray = array('user_id' => $request->user_id, 'position_id' => $exp_user_pos_id_value);

                $arrayUHPUpdate = array('orgId' => $this->orgId, 'createdBy' => $this->authUserId, 'user_id' => $request->user_id, 'position_id' => $exp_user_pos_id_value);
                UserHasPosition::updateOrCreate($whereUHPArray, $arrayUHPUpdate);
            }
            DB::commit();
            return response()->json(['result_code' => 1, 'message' => 'Position Updated Successfully.'], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json(['result_code' => 0, 'message' => "Sorry , Changes not updated. Please try again!!!!!"], 200);//$e->getMessage()
            // something went wrong with the transaction, rollback
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['result_code' => 0, 'message' => "Sorry , Changes not updated. Please try again!!!!!"], 200);
            return Redirect::back()->withErrors($e->getMessage());
        }
        //return ($request->all());
    }


    /**
     * @Function name : loadTeamPositions
     * @Purpose : Load Team with Position
     * @Added by : Sathish
     * @Added Date : Nov 07, 2019
     */
    public function loadTeamPositions(Request $request)
    {

        // DB::beginTransaction();
        // try {
            $is_manual_schedule = $request->is_manual_schedule;
            $team_id = $request->team_id;
            
            $whereLPUpdArray = array('team.id' => $team_id,'team.orgId' => $this->orgId);
            $data['loadTeamPositions'] = Position::loadTeamPositions($whereLPUpdArray,null,null,null,null,null)->get();
            //dd($data['loadTeamPositions']->count(),$whereLPUpdArray);
            

            return view('settings.schedule.load_team_positions', $data);
            
        //     DB::commit();
        //     return response()->json(['result_code' => 1, 'message' => 'Position Updated Successfully.'], 200);
        // } catch (\Illuminate\Database\QueryException $e) {
        //     DB::rollback();
        //     return response()->json(['result_code' => 0, 'message' => "Sorry , Changes not updated. Please try again!!!!!"], 200);//$e->getMessage()
        //     // something went wrong with the transaction, rollback
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return response()->json(['result_code' => 0, 'message' => "Sorry , Changes not updated. Please try again!!!!!"], 200);
        //     return Redirect::back()->withErrors($e->getMessage());
        // }
    }

    /**
     * @Function name : loadMemberWithPositions
     * @Purpose : Load Team with Position
     * @Added by : Sathish
     * @Added Date : Nov 07, 2019
     */
    public function loadMemberWithPositions(Request $request)
    {

        // DB::beginTransaction();
        // try {
            $user_pos_id = $request->user_pos_id;
            $user_team_id = $request->user_team_id;
            
            $dataObj['position_id'] = $request->user_pos_id;
            $dataObj['groupBy'] = array('users.id', 'user_has_position.position_id');
            $dataObj['orderBy'] = array('user_has_position.position_id'=>'desc');

            $whereLPUpdArray = array('users.orgId' => $this->orgId);
            $loadMemberWithPositions = $data['loadMemberWithPositions'] = Position::loadMemberWithPositions($whereLPUpdArray,null,null,null,null,$dataObj)->get();

            $html = "";

            $html .= '<select name="assign_user_id" id="assign_user_id" class="form-control selectddmember" style="width: 300px !important;"><option value="">--Select--</option>';
            if($loadMemberWithPositions->count() > 0){
                foreach($loadMemberWithPositions as $loadMemberWithPositionsValue){
                    $html .= '<option value='.$loadMemberWithPositionsValue->usersid.'>'.$loadMemberWithPositionsValue->first_name.'</option>';
                }

            }
            $html .= "</select>";
            return $html;
            //dd($data['loadMemberWithPositions']->toArray(),$whereLPUpdArray);
            

            //return view('settings.schedule.load_member_team_positions', $data);
                
            
        //     DB::commit();
        //     return response()->json(['result_code' => 1, 'message' => 'Position Updated Successfully.'], 200);
        // } catch (\Illuminate\Database\QueryException $e) {
        //     DB::rollback();
        //     return response()->json(['result_code' => 0, 'message' => "Sorry , Changes not updated. Please try again!!!!!"], 200);//$e->getMessage()
        //     // something went wrong with the transaction, rollback
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return response()->json(['result_code' => 0, 'message' => "Sorry , Changes not updated. Please try again!!!!!"], 200);
        //     return Redirect::back()->withErrors($e->getMessage());
        // }
    }

     
}
