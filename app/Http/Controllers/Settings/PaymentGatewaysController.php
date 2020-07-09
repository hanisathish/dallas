<?php

namespace App\Http\Controllers\Settings;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\PaymentGateways;
use App\Models\PaymentGatewayStore;
use App\Models\Resources;
use App\Models\Roles;
use App\Models\Organization;
use App\Models\PaymentGatewayParameters;
use DB;
use Config;
use DataTables;
use Auth;


class PaymentGatewaysController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->common_file_upload_path = Config::get('constants.FILE_UPLOAD_PATH');
        $this->common_file_download_path = Config::get('constants.FILE_DOWNLOAD_PATH');
        $this->userSessionData = Session::get('userSessionData');

        $this->orgId = $this->userSessionData['umOrgId'];
    }

    public function index() {

        $data['title'] = $this->browserTitle . " - Payment Gateways Management";
		
        return view('settings.payment_gateways.index', $data);
    }


    public function list(Request $request){
		
		
        $payment_gateways = PaymentGateways::listPaymentGatewaysValues($this->orgId);

        return DataTables::of($payment_gateways)
		
                        ->addColumn('action', function($row) {							
                            $btn = '<a class="nav-link" href="payment_gateways/edit/'.$row->payment_gateway_id.'"><i class="fa fa-lg"></i>Edit</a>';
                            return $btn;
                        })

                        ->rawColumns(['action','image'])
                        ->make(true);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOrUpdate(Request $request)
    {
        	
			    $insertData = $request->all();	
                
				//dd($insertData);				

				$insertData = $request->except(['_token']);

				$insertData['createdBy']= Auth::id();
				
				$insertData['orgId']= $this->orgId;
				
				$insertData['active']= $request['active'];	
			
				
			    $wherePGSArray = array('orgId' => $insertData['orgId'], 'payment_gateway_id' => $request['payment_gateway_id'], 'gateway_name'=> $insertData['gateway_name']);
				
			    $arrayPGSUpdate = array('orgId' => $insertData['orgId'], 'payment_gateway_id' => $request['payment_gateway_id'], 'gateway_name'=> $insertData['gateway_name'],'active' => $insertData['active']);
				   
                PaymentGateways::updateOrCreate($wherePGSArray, $arrayPGSUpdate);	   				
				
				$whereArray = array('payment_gateway_id'=> $request['payment_gateway_id']);
				$selectFromPaymentGatewayParameters = $data['selectFromPaymentGatewayParameters']  = PaymentGatewayParameters::selectFromPaymentGatewayParameters($whereArray,null,null,null,null,null)->get();
				
				
			    foreach($selectFromPaymentGatewayParameters as $selectFromPaymentGatewayParametersValues){
										
				    $wherePGSArray = array('orgId' => $insertData['orgId'], 'payment_gateway_id' => $request['payment_gateway_id'], 'payment_gateway_parameter_id'=> $selectFromPaymentGatewayParametersValues->parameter_id );

                    $arrayPGSUpdate = array('orgId' => $insertData['orgId'], 'payment_gateway_id' => $request['payment_gateway_id'], 'payment_gateway_parameter_id'=> $selectFromPaymentGatewayParametersValues->parameter_id, 'payment_gateway_parameter_value'=>$request['payment_gateway_parameter_value_'.$selectFromPaymentGatewayParametersValues->parameter_id],'active' => $insertData['active']);
				   
                   PaymentGatewayStore::updateOrCreate($wherePGSArray, $arrayPGSUpdate);	
					
					
				}
              
				return redirect('/settings/payment_gateways');

    }
	
	
	

    public function editPaymentGateways(Request $request) {
		
		$data['title'] = $this->browserTitle . " - ";
		  
		$data['gatewayId']  =  $request->segment(4);
		
		$orgId = $this->orgId;
		
		$whereArray = array('payment_gateway_id' => $request->segment(4));
		
	    $data['getPaymentGatewayParameterValues'] = PaymentGatewayStore::getPaymentGatewayParameterValues($request->segment(4), $orgId);
		
	    //$data['getPaymentGatewayParameterDetails'] = PaymentGatewayParameters::getPaymentGatewayParameterDetails($request->segment(4), $orgId);
        //dd($data['getPaymentGatewayParameterValues']);		
		
		$data['selectFromPaymentGateways']  = PaymentGateways::selectFromPaymentGateways($whereArray,null,null,null,null,null)->get()[0];
				
        $selectFromPaymentGatewayParameters = $data['selectFromPaymentGatewayParameters']  = PaymentGatewayParameters::selectFromPaymentGatewayParameters($whereArray,null,null,null,null,null)->get();
			
        return view('settings.payment_gateways.create',$data);
		
    }

}
