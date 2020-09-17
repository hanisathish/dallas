<?php

namespace App\Http\Controllers;

// use App\Helpers\CustomHelperFunctions;
use Illuminate\Http\Request;
use App\Http\Requests;


use Config;
use Mail;
use Exception;

use Auth;

use App\Models\CommTemplate;

use App\User;
use App\Lookup;
use App\Models\UserMaster;
use App\Models\CommMaster;
use App\Helpers\CommunicationHelper;

class CronTaskController extends Controller {

    /**
     * @Function name : sendBirthdayWishes
     * @Purpose : sendBirthdayWishes
     * @Added by : Sathish
     * @Added Date : Jun 12, 2019
     */
    public function sendBirthdayWishes() 
    {
        $todayDM=date('m-d');
        $selectUserMasterDetail = UserMaster::select('*');

        $userDet = $selectUserMasterDetail->where('dob', 'LIKE', '%' . $todayDM . '%');
        if($userDet->count() > 0){
            foreach($userDet->get() as $userDetVal){
                CommunicationHelper::generateCommunications('birthday', $userDetVal->orgId, '1', $userDetVal->id, array($userDetVal->id));
                
            } 
        }
        // 
        // dd($selectUserMasterDetail->count());
    }

    /**
     * @Function name : sendAnniversaryWishes
     * @Purpose : sendAnniversaryWishes
     * @Added by : Sathish
     * @Added Date : Jun 12, 2019
     */
    public function sendAnniversaryWishes() 
    {
        $todayDM=date('m-d');
        $selectUserMasterDetail = UserMaster::select('*');

        $userDet = $selectUserMasterDetail->where('doa', 'LIKE', '%' . $todayDM . '%');
        if($userDet->count() > 0){
            foreach($userDet->get() as $userDetVal){
                CommunicationHelper::generateCommunications('anniversary', $userDetVal->orgId, '1', $userDetVal->id, array($userDetVal->id));
                
            } 
        }
        // 
        // dd($selectUserMasterDetail->count());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
