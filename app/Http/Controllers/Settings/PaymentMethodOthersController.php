<?php

namespace App\Http\Controllers\Settings;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location;
use DB;
use Config;
use App\Models\Resources;
use App\Models\Roles;
use App\Models\PaymentMethodOthers;
use Illuminate\Http\Response;
use DataTables;
use Auth;
use App\Models\Organization;
use Illuminate\Support\Facades\Session;


class PaymentMethodOthersController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->common_file_upload_path = Config::get('constants.FILE_UPLOAD_PATH');
        $this->common_file_download_path = Config::get('constants.FILE_DOWNLOAD_PATH');
        $this->userSessionData = Session::get('userSessionData');
    }

    public function index() {

        $data['title'] = $this->browserTitle . " - Payment Management";

        return view('settings.other_payment_methods.index', $data);
    }

    public function list(Request $request){
		
        $orgId = Auth::user()->orgId;
		
        //$payment_gateways = PaymentMethodOthers::listOtherPaymentGateways($orgId);
		
        $payment_gateways = PaymentMethodOthers::listOtherPaymentGatewaysMethods($request->search['value']);		

        return DataTables::of($payment_gateways)
		
                        ->addColumn('action', function($row) {							
                            $btn = '<a class="nav-link" href="payment_others/edit/'.$row->other_payment_method_id.'"><i class="fa fa-lg"></i>Edit</a>';
                            return $btn;
                        })

                        ->rawColumns(['action','image'])
                        ->make(true);
    }


    public function addPaymentPage(Request $request)
	{
        $data['title'] = $this->browserTitle . " - Payment Management";
        return view('settings.other_payment_methods.create', $data);
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
		  
		   $otherpaymentId = $request->otherpaymentId;
		  
           $insertData = $request->except(['otherpaymentId','_token']);
		  
		  
		   if($otherpaymentId > 0) { 
            
			  $insertData['updatedBy']= Auth::id();
			 
              PaymentMethodOthers::where("other_payment_method_id",$otherpaymentId)->update($insertData);
			
           }
            else {
		
			   $insertData['createdBy']= Auth::id();
			  
			   $insertData['orgId']= Auth::user()->orgId;
			
			   PaymentMethodOthers::create($insertData);
		    }
          
		return redirect('/settings/payment_others');

    }


    public function editPaymentMethodOther(Request $request, $otherpaymentId){
		
        $data['title'] = $this->browserTitle . " - ";
		
		$otherpayment = PaymentMethodOthers::findOrFail($otherpaymentId);

        $data['otherpayment'] = $otherpayment;
		
		
		$whereArray = array('other_payment_method_id' => $request->segment(4));
		
		$selectFromPaymentMethodOthers = $data['selectFromPaymentMethodOthers']  = PaymentMethodOthers::selectFromPaymentMethodOthers($whereArray,null,null,null,null,null)->get()[0];
			
        return view('settings.other_payment_methods.create',$data);
    }
	
}
