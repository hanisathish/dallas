<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Config;
use yajra\Datatables\Datatables;
use App\Helpers\CommunicationHelper;

use App\Models\Schedule;
use App\Models\Giving;
use App\Models\Events;
use App\Models\PaymentGateways;
use App\Models\PaymentGatewayStore;
use App\Models\PaymentMethodOthers;
use App\Models\MasterLookupData;
use App\Models\SchedulingUser;
use App\Models\CommTemplate;
use App\Models\Team;
use App\Models\UserMaster;
use App\User;
use Auth;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;


class GivingController extends Controller
{
    public function __construct()
    {
		 
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->userSessionData = Session::get('userSessionData');
        $this->orgId = $this->userSessionData['umOrgId'];	
        $this->authUserId = $this->userSessionData['umId'];
        $this->todays_date = Config::get('constants.TODAYSDATE');
        $this->todays_date_time = Config::get('constants.TODAYSDATETIME');
    }

    public function givingIndex(){
        $data['title'] = $this->browserTitle . " - Givings List";
        return view('givings.index', $data);
    }

    public function getGivingList(){
		
        $result = array();
					
        $orgId = Auth::user()->orgId;
		
	    $givings = Giving::getGivingList($orgId)->get();
		
	    //$givings = Giving::getGivingList();
		//dd($givings);	
		
	    //$givings = Giving::where('orgId', $this->orgId)->select("id", "type", "amount")->orderBy("id", "desc")->get();
        			
        //$i = 1;
        foreach ($givings as $giving) {
			
            // $row = [$i, $giving->orgName, $giving->gateway_name, $giving->payment_method, $giving->amount, $giving->pay_mode, $giving->type, $giving->eventName, $giving->userfullname, $giving->transaction_status, $giving->final_status, $giving->transDate];

            $row = [$giving->gateway_name, $giving->amount, $giving->type, $giving->eventName, $giving->userfullname, $giving->transaction_status, $giving->transDate];
            $result[] = $row;
            //$i += 1;
        }

        return Datatables::of($result)->rawColumns([6])->make(true);
    }

    
    public function createOrEditPage($giving_id = null){
		
        $data['title'] = $this->browserTitle . " - Giving List";
		
        $data['giving_id'] =  $giving_id;
		
		//$data['user_id'] = Auth::id();
		
		$data['userRole'] = $this->userSessionData['umUserRoleTag'];
		
		$data['userId'] = $this->userSessionData['umId'];
		
		$data['orgId'] = $this->userSessionData['umOrgId'];
		
		$wherArray = array('orgId'=> $this->userSessionData['umOrgId']);
		
		$data['user_id'] = UserMaster::crudUserMasterDetail($wherArray,null,null,null,null,null,null,'1')->get();
		
	
	    $whereOrgArray=array('orgId'=>$this->orgId,'active'=>1);
        $data['payment_mode'] = PaymentGateways::selectFromPaymentGateways($whereOrgArray)->get();
		
		
		$whereOrgArray=array('orgId'=>$this->orgId,'status'=>1);
        $data['other_payment_mode'] = PaymentMethodOthers::selectFromPaymentMethodOthers($whereOrgArray)->get();
			
		//dd($data['payment_mode']);
		
		
		
		//Get stripe public key & secret key		 
        $org_id = $this->userSessionData['umOrgId'];		
        $stripe_keys = PaymentGatewayStore::getPaymentGatewayKeys($org_id)->get()->toArray();

        if ($stripe_keys != "failure") {
            foreach ($stripe_keys as $key => $fields) {

                if ($fields['parameter_name'] == "Public Key") {
                    $data['public_key'] = $fields['payment_gateway_parameter_value'];
                }
                if ($fields['parameter_name'] == "Secret Key") {
                    $data['secret_key'] = $fields['payment_gateway_parameter_value'];
                }
            }
        }
		
		//dd($data['public_key']);
		
		
        //$whereTeamArray=array('orgId'=>$this->orgId);		
        //$data['team_id'] = Team::selectFromTeam($whereTeamArray)->get();		

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
        //dd($data['upcoming_events']);
        //dd($data['team_id']->get()->toArray(),$whereTeamArray);
        
        if($giving_id){
			
            $whereSchArray = array('id'=>$giving_id);
			
            $crudGiving = Giving::crudGiving($whereSchArray,null,null,null,null,null,null,'1')->get();
			
            if($crudGiving->count() > 0){
                $data['crudGiving'] = $crudGiving[0];
            }else{
                return redirect('settings/givings');
            }
            
        }
        //dd($data['crudGiving']->count());
        return view('givings.create', $data);
    }


    public function storeOrUpdateGivings(Request $request){
		
        $payload = $request->all();

        $org_id = $this->userSessionData['umOrgId'];

        $customer_id = null;
        $final_status=1;
        $transaction_status=1;
        $submited_datetime = null;
        $confirmed_date = null;
        if($request->payment_gateway_id == 1){
            //stripe payment

            //Get stripe public key & secret key    
            $stripe_keys = PaymentGatewayStore::getPaymentGatewayKeys($org_id)->get()->toArray();

            if ($stripe_keys != "failure") {
                foreach ($stripe_keys as $key => $fields) {

                    if ($fields['parameter_name'] == "Public Key") {
                        $data['public_key'] = $fields['payment_gateway_parameter_value'];
                    }
                    if ($fields['parameter_name'] == "Secret Key") {
                        $data['secret_key'] = $fields['payment_gateway_parameter_value'];
                    }
                }
            }

            Stripe::setApiKey($data['secret_key']);
        
            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source'  => $request->stripeToken,
                'description' => $request->type
            ));
            //dd($customer);
            if (!($customer->id)) {
                //$response = $customer->getResponse(); 
                $response = $customer->getResponse();
                $statusCode = $response->getStatusCode();
                $rawOutput = json_decode($response->getBody(true), true);
                $error = isset($rawOutput['error']) ? $rawOutput['error'] : [];
                $errorCode = isset($error['code']) ? $error['code'] : null;
                $errorType = isset($error['type']) ? $error['type'] : null;
                $message = isset($error['message']) ? $error['message'] : null;
                //Session::flash('rule_based_msg_alert', 'Error');
                Session::flash('payment_msg', $message . " Please try later.");
                return redirect('/settings/givings/manage/');
            }

            $charge = Charge::create(array(
                'customer' => $customer->id,
                'amount'   => $request->input('amount'),
                'currency' => Config::get('constants.CURRENCYCODE'),
                'description' => $request->type
            ));

            $transaction_status=2;
            $customer_id = $customer->id;
            $final_status=3;
            $submited_datetime = null;
            $confirmed_date = $this->todays_date_time;
        }elseif($request->payment_gateway_id == 2){


        }elseif($request->payment_gateway_id == 3){
            //other payment
            $transaction_status=1;
            $submited_datetime = $this->todays_date_time;
            $confirmed_date = null;

        }
		
		
		
		$giving = null;
		
        $isNewSchedule = true;
		
        if(isset($payload['givingId'])){
            $giving = Giving::where("id", $payload["givingId"])->first();
            $isNewSchedule = false;
        }
		else
		{
            $giving = new Giving();
            $giving->orgId = $this->orgId;
            $giving->createdBy = $this->userSessionData['umId'];
            $giving->pay_mode = "Credit";
            $giving->transaction_date = $this->todays_date_time;
            $giving->transaction_status = $transaction_status;
            $giving->customer_id  = $customer_id;
            $giving->final_status  = $final_status;
            $giving->submited_datetime  = $submited_datetime;
            $giving->confirmed_date  = $confirmed_date;

        }
		
		
		
        //dd($giving);
		
        // return $payload;
		//'pay_mode', 'purpose_note', 'transaction_date',
        $fields = [ 'type', 'user_id', 'orgId', 'event_id', 'email', 'first_name', 
                    'middle_name', 'last_name', 'mobile_no', 'payment_gateway_id', 
                    'other_payment_method_id', 'amount'];
		
        foreach($fields as $field) {
			 $giving[$field] = $payload[$field];          
        }
		
        $giving->save();
		
		//dd($giving);
		       
        return redirect('settings/givings/');
		
        return ["message"=> "Givings has been successfully stored or updated"];
    }

 
}

