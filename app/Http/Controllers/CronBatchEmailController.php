<?php

namespace App\Http\Controllers;

// use App\Helpers\CustomHelperFunctions;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\CronBatchEmail;
// use App\Models\FeatureList;
use Config;
use Mail;
use Exception;
// use App\Models\MessageMaster;
use Auth;

class CronBatchEmailController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
	$error_msg = "";
        $send_mail_error = "";
        $cron_emails = CronBatchEmail::selectEmails(); 

        // dd($cron_emails);
        // dd(Auth::user());
        if ($cron_emails != "failure") 
        {
            $cron_id_array = array_column($cron_emails, "cron_id");
            $update_details = array(
                'send_status' => 3
            );
            
            CronBatchEmail::whereIn('cron_id', $cron_id_array)
                    ->update($update_details);
            //$from = Config::get('constants.AdminFromMail');
            
            foreach ($cron_emails as $key => $arr_fields)                 
            {
                echo "<br> emails " . $arr_fields['recipient'];                
                // $cc_list = $arr_fields['cc_recipient'];
                
                $to_list = $arr_fields['recipient'];
                $getToEmails = explode(",", $to_list);
                $getToEmails = array_map("strtolower", $getToEmails);
                $getToEmails = array_map("trim", $getToEmails);
                $getToEmails = array_filter($getToEmails);
                $getToEmails = array_unique($getToEmails);
                $getToEmails = array_values($getToEmails);
                $msg = $cron_emails[$key]['message'];
                $sub = $cron_emails[$key]['subject'];
                
                $sent_from = $arr_fields['sent_from'];
                $sent_from_email = $arr_fields['sent_from_email'];
                
                
                if($sent_from && $sent_from_email){
                    $msg_sent_by_Master = $sent_from;
                    $msg_sent_by_id_Master = $sent_from_email;
                }
        
                $from = $sent_from_email;//'Church Software';//'dummy8088@gmail.com';
             

            

            $msg = trim($msg);
            
            if (!empty($cron_emails[$key]['file_attach'])) 
            {

                $offset = unserialize($cron_emails[$key]['files_offset']);

                $file = unserialize($cron_emails[$key]['file_attach']);

                $size = count($offset);
                 
				try {
                    $send_mail = Mail::send(array(), array(), function ($email) use ($sub, $getToEmails, $from, $file, $size, $offset, $msg, $msg_sent_by_id_Master, $msg_sent_by_Master) 
                    {

                        $email->to($getToEmails)
                                ->from($from);
                                if($msg_sent_by_id_Master && $msg_sent_by_Master){
                                    $email->replyTo($msg_sent_by_id_Master,$msg_sent_by_Master);
                                }
                                $email->subject($sub);
                        for ($i = 0; $i < $size; $i++) 
                        {
                            $email->attach($file[$offset[$i]]);
                        }
                        if ($msg != "") 
                        {
                            $email->setBody($msg, 'text/html');
                        }
                    });

                } catch (Exception $ex) {
                            $error_msg = $ex->getMessage();
                            $send_mail_error = "failure";
                        }
				 
            } 
            else 
            {
                 
		      try {
                    $send_mail = Mail::send(array(), array(), function ($email) use ($sub, $getToEmails, $from, $msg, $msg_sent_by_id_Master, $msg_sent_by_Master) 
                    {
                        $email->to($getToEmails)
                                ->from($from);
                                if($msg_sent_by_id_Master && $msg_sent_by_Master){
                                    $email->replyTo($msg_sent_by_id_Master,$msg_sent_by_Master);
                                }
                                $email->subject($sub)
                                ->setBody($msg, 'text/html');
                    });
                } catch (Exception $ex) {
                            $error_msg = $ex->getMessage();
                            $send_mail_error = "failure";
                    }
		
            }
            if ($send_mail_error == "failure") {
                    $error_sent_mails[] = $cron_emails[$key]['cron_id'];
                    $update_details = array(
                        'send_status' => 2,
                        'mail_error' => $error_msg,
                    );
                } else {
                    $update_details = array(
                        'send_status' => 1,
                        'mail_error' => '',
                    );
                }
            echo "<pre>";
            print_r($update_details);
            echo "</pre>";
            echo "<br> cron " . $cron_emails[$key]['cron_id'];
            CronBatchEmail::updateCron($update_details, $cron_emails[$key]['cron_id']);
            $send_mail_error = "";
          }
        }
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
