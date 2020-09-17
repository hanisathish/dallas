<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Config;
use App\Models\SendSMS;
use Illuminate\Http\Response;
use App\Helpers\CommunicationHelper;


class CommonController extends Controller {

    public function __construct() {
        
    }

    public function index() {
        
    }

    /**
     * @Function name : pushSMSUrl
     * @Purpose : pushSMSUrl
     * @Added by : Sathish
     * @Added Date : Jun 12, 2019
     */
    public function pushSMSUrl(Request $request) {
        
        $request = $_REQUEST["data"];
        $jsonData = json_decode($request,true);
        
        foreach($jsonData as $key => $value)
        {
             // request id
            $requestID = $value['requestId'];
            $userId = $value['userId'];
            $senderId = $value['senderId'];
            foreach($value['report'] as $key1 => $value1)
            {
                //detail description of report
                $desc = $value1['desc'];
                // status of each number
                $status = $value1['status'];
                // destination number
                $receiver = $value1['number'];
                //delivery report time
                $date = $value1['date'];


                $updateSmsData['description']= $desc;
                $updateSmsData['del_status']= $status;
                // $updateSmsData['updatedBy']= $receiver;
                $updateSmsData['msg_sent_date']= $date;

                
                SendSMS::where("request_id",$requestID)->update($updateSmsData);

                // $query = "INSERT INTO mytable (request_id,user_id,sender_id,date,receiver,status,description) VALUES ('" . $requestID . "','" . $userId . "','" . $senderId . "','" . $date . "','" . $receiver . "','" . $status . "','" . $desc . "')";
                // mysqli_query($link, $query);
            }
        }
    }
     
}
