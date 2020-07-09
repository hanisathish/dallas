@extends('layouts.default')

@section('content')

<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item active">Payment Gateways Management</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
	<div class="col-sm-0 col-md-1 col-lg-2"></div>
	<div class="col-sm-12 col-md-10 col-lg-8 card">

<form method="post" action="{{ route('payment.store') }}" name="create_payment_form" id="create_payment_form" enctype="multipart/form-data">
 <div id="create_payment_form_status"></div>
    <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30" style="margin-bottom: 0">
                            <div class="card-body">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}">								
									@foreach($selectFromPaymentGatewayParameters as $value)
									 <div class="form-group row">
										<label for="example-date-input" class="col-sm-3 col-form-label">{{ $value->parameter_name }}</label>
										<div class="col-sm-9">
											<input class="form-control" required="" type="text" value="" id="payment_gateway_parameter_value_<?php echo $value->parameter_id; ?>" name="payment_gateway_parameter_value_<?php echo $value->parameter_id; ?>" >
										</div>
									 </div>						 
									@endforeach									
									
									<div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Select Status</label>
											
                                            <div class="col-sm-9">                                                
                                                <select  name='active' id='active' class='form-control'>
                                                    <option value="">--Select--</option>                        
                                                    <option value="0">Inactive</option>                        
                                                    <option value="1">Active</option>                        
                                                </select>   
                                            </div>
                                     </div>		
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>				
				<input type="hidden" name="gateway_name" value="<?php echo $selectFromPaymentGateways['gateway_name']; ?>"/>
				<input type="hidden" name="payment_gateway_id" value="<?php echo $gatewayId; ?>"/>
				<div class="form-group">
				<div>
					<button type="submit" class="btn btn-primary waves-effect waves-light">
						Submit
					</button>
					<a href="{{ URL::asset('settings/payment_gateways')}}" type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</a>
				</div>
			    </div>
  </form>
</div>   
</div>  

@endsection