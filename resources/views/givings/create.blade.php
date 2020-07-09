@extends('layouts.default')

@section('content')
<div style="width:100vw">
    @include('givings.header')

    <?php
        $formUrl = "/settings/givings/store";
        $giving_id = isset(request()->route()->parameters['giving_id'])? request()->route()->parameters['giving_id'] : null;
        if($giving_id){
            //$formUrl = $formUrl ."/". $giving_id;
        }
    ?>
    <div class="row">
        <div class="col-sm-0 col-md-1 col-lg-2"></div>
        <div class="col-sm-12 col-md-10 col-lg-8 card">
            <!-- <div class="card m-b-30"> -->
            <div class="card-body pl-0 pr-0">
                <h5 class="mt-0 pl-3"> {{($giving_id)? 'Edit' : "Create" }} Giving</h5>
                <hr />
                <span id="pay_conf_msg" style="font-size: 15px;font-weight: bold;">
				    @if (Session::has('payment_msg'))
				    {{ Session::get('payment_msg') }}<br/><br/>
				    @endif
				</span>
                <div class="row p0 m-0">
                    {!! Form::open(array('id'=>'givingsForm','name'=>'givingsForm','method' => 'post', 'url' => $formUrl, 'class' => 'givingsForm col-sm-12 card p-2','files' => true)) !!}
                    
                    <!-- <form method="post" action="{{ route('settings.schedulling.store') }}" name="givingsForm" id="givingsForm" enctype="multipart/form-data" class="col-sm-12 card p-2"> -->
					    
						<input type="text" id="orgId" name="orgId" value="{{$orgId}}" class="d-none">
						 
                        <input type="text" id="givingId" name="givingId" value="{{$giving_id}}" class="d-none">
						<input type="hidden" id="stripeToken" name="stripeToken" />
  						<input type="hidden" id="stripeEmail" name="stripeEmail" />
                        <!--<input type="text" id="user_id" name="user_id" value="{{$user_id}}" class="d-none">-->
						
 
                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30">
                                    <div class="card-body">
									
									    <div class="form-group row">
											<label for="example-date-input" class="col-sm-2 col-form-label">Type</label>
											<div class="col-sm-10">
											<select class="form-control" name="type" id="type">
											    <option value="">--Select--</option> 
												<option {{ (isset($crudGiving) && $crudGiving->type==1)?'selected':''}}  value="1">Donation</option>
												<option {{ (isset($crudGiving) && $crudGiving->type==2)?'selected':''}}  value="2">Event</option>                                 
											</select>
											</div>
										</div>
						
						
                                        <div id="dvEvent" style="display: none">
											<div class="form-group row">
												<label for="example-date-input" class="col-sm-2 col-form-label">Event Date</label>
												<div class="col-sm-10">
													<input class="form-control selecteventdate" type="text" value="{{ old('event_date', isset($crudGiving) ? $crudGiving->event_date : '') }}" name="event_date" id="example_date_input">

													<input class="form-control" type="hidden" value="{{ old('event_id_hidden', isset($crudGiving) ? $crudGiving->event_id : '') }}" name="event_id_hidden" 
													 id="event_id_hidden">
												</div>
	 

											</div>
											<div class="form-group row">
												<label class="col-sm-2 col-form-label">Select Event</label>

												<div class="col-sm-10 load_events" id="load_events">
													
													<select  name='event_id' id='event_id' class='form-control'>
														<option value="">--Select--</option>                        
													</select>    
													
													
												</div>
											 </div>
										   </div>
										   <?php
										   //echo $userRole;
										   //echo $userId;
										    if($userRole !== "member"){
										   ?>
										   
										   <div class="form-group row">
											<label for="example-date-input" class="col-sm-2 col-form-label">Users</label>
											<div class="col-sm-10">
											<select class="form-control" name="user_id" id="user_id">
											   <option value="">--Select--</option>
										          @foreach($user_id as $user) 
												     <option value="{{ $user->id }}">{{ $user->full_name }}</option>														 
												  @endforeach												                                
											</select>
											</div>
										   </div>
											<?php
											 }
											 else
											 {
											?>
											
											<div class="form-group row">
											
											  <input class="form-control" type="hidden" value="<?php echo $userId; ?>" id="user_id" name="user_id">
											  
											</div>
									    
										  <?php
  										     } 
										 
										     if($userRole !== "member") {
												
										    ?>
										
                                       <div id="dvUser" style="display: block">
										<div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ old('email', isset($crudGiving) ? $crudGiving->email : '') }}" id="email" 
												name="email" >
                                            </div>
                                        </div>

                                        
										<div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">First Name</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ old('first_name', isset($crudGiving) ? $crudGiving->first_name : '') }}" id="first_name" 
												name="first_name" >
                                            </div>
                                        </div>
										
										
										<div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Middle Name</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ old('middle_name', isset($crudGiving) ? $crudGiving->middle_name : '') }}" id="middle_name" 
												name="middle_name" >
                                            </div>
                                        </div>
										
										
										
										<div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Last Name</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ old('last_name', isset($crudGiving) ? $crudGiving->last_name : '') }}" id="last_name" 
												name="last_name" >
                                            </div>
                                        </div>
										
										
										<div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Mobile Number</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ old('mobile_no', isset($crudGiving) ? $crudGiving->mobile_no : '') }}" id="mobile_no" 
												name="mobile_no" >
                                            </div>
                                        </div>
	                                    </div>
										
										<?php
										 }
										 else
										 {
										?>
                                        <input class="form-control" type="hidden" value="" id="email" name="email">
                                        <input class="form-control" type="hidden" value="" id="first_name" name="first_name">
                                        <input class="form-control" type="hidden" value="" id="middle_name" name="middle_name">
                                        <input class="form-control" type="hidden" value="" id="last_name" name="last_name">
                                        <input class="form-control" type="hidden" value="" id="mobile_no" name="mobile_no">
										<?php										 
										 }
										?>
									

                                        <div class="form-group row">
											<label for="example-date-input" class="col-sm-2 col-form-label">Payment Mode</label>
											<div class="col-sm-10">
											<select class="form-control" name="payment_gateway_id" id="payment_gateway_id">
											   <option value="">--Select--</option> 
												@foreach($payment_mode as $value) 
												     <option value="{{ $value->payment_gateway_id }}">{{ $value->gateway_name }}</option>														 
												@endforeach                                                     											
											</select>
											</div>
										</div>
										
                                     <div id="dvSubPay" style="display: none">
                                        <div class="form-group row">
											<label for="example-date-input" class="col-sm-2 col-form-label">Sub Payment Mode</label>
											<div class="col-sm-10">
											<select class="form-control" name="other_payment_method_id" id="other_payment_method_id">
											    <option value="">--Select--</option> 
												@foreach($other_payment_mode as $value)
												     <option value="{{ $value->other_payment_method_id }}">{{ $value->payment_method }}</option>														 
												@endforeach                               
											</select>
											</div>
										</div>	
                                     </div>										
										
										<div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Amount</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ old('amount', isset($crudGiving) ? $crudGiving->amount : '') }}" id="amount" 
												name="amount" onInput="edValueKeyPress()">
                                            </div>
                                        </div>

                                        <div class="form-group row">
		                                    <label for="example-date-input" class="col-sm-2 col-form-label">Description</label>
		                                    <div class="col-sm-10">
		                                        <textarea name="purpose_note" id="purpose_note" class="form-control">{{ isset($crudGiving)?$crudGiving->purpose_note:'' }}</textarea>
		                                    </div>
		                                </div>
										
									<!-- <div id="dvStripe" style="display: none">	
													
									    <div class="form-group row">
											<span>
												<label id="online_payment">
													<input class="ace" type="radio" name="rad_pay_option" id="rad_pay_option" value="1" checked />
													<span class="lbl">&nbsp; Pay Online</span>
												</label>
											</span>
                                        </div>										
									</div>	 -->
																			
							  <?php
								//if ($payment_status == 'NONE') {
							  ?>
						
                              

                        <?php //} ?>
							<div class="pay_btn" id="pay_btn" style="display: none">	
								<script>
								function getValue() {
								  var test = document.getElementById("amount").value;
								  $('.stripe-button').attr('data-amount', test);
								  //return test;
								}
								</script>
								 

								<input type="hidden" name="stripe_public_key" id="stripe_public_key" value="<?php echo $public_key; ?>">
 	
								<div class="form-group">
									<div>
										<button id="customButton" type="button" class="btn btn-primary waves-effect waves-light">
											Pay
										</button>
										<a href="{{ URL::asset('settings/givings')}}" type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</a>
									</div>
								 </div>
							</div>

			
							<div class="sub_btn" id="sub_btn" style="display: none">			
								<div class="form-group">
									<div>
										<button type="button" onclick="return submit_payment('1');"  class="btn btn-primary waves-effect waves-light">
											Submit
										</button>
										<a href="{{ URL::asset('settings/givings')}}" type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</a>
									</div>
								 </div>
							</div>
							
										
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </form>
                </div>
            </div>
            <!-- </div> -->
        </div>
    </div>
    
</div>
<script type="text/javascript" src="{{ URL:: asset('js/custom/givings.js')}}"></script>

<script src="https://checkout.stripe.com/v2/checkout.js"></script>

<script type='text/javascript'>

var handler = StripeCheckout.configure({
    key: $("#stripe_public_key").val(),
    image: '{{ URL::asset('assets/theme/images/bible-cross-logo.png')}}',
    token: function(token) {
        $("#stripeToken").val(token.id);
        $("#stripeEmail").val(token.email);
        $("#givingsForm").submit();
    }
  });

  $('#customButton').on('click', function(e) {
    var amount = $("#amount").val();
    // Open Checkout with further options
    handler.open({
      name: 'Organization',
      description: 'Payment for : ' + $("#type option:selected").text()+' ($ '+amount+')',
      amount: amount
    });
    e.preventDefault();
  });

  // Close Checkout on page navigation
  $(window).on('popstate', function() {
    handler.close();
  });

function submit_payment(counter) {
	//alert("givingsForm");
	var errorNumbers = chkGivingCreateValidateStatus.numberOfInvalids();
    if (errorNumbers == 0) {
        $('#givingsForm').submit();
    	return true;
    } else {

    }

}
function edValueKeyPress() {
    var amount = document.getElementById("amount");
    var s = amount.value;
	var stripeamount = parseInt(s*100);
	//alert(stripeamount);
    $(".stripe-button").attr("data-amount",stripeamount);	
}

$(function () {
	$("#type").change(function () {
		if ($(this).val() == "2") {
			$("#dvEvent").show();
		} else {
			$("#dvEvent").hide();
		}
	});
 });
 
 $(function () {
	$("#user_id").change(function () {
		//alert($(this).val());
		if ($(this).val() =="") {
			$("#dvUser").show();
		} else {
			$("#dvUser").hide();
		}
	});
 });
 
 $(function () {
	$("#payment_gateway_id").change(function () {	
		var selectedText = $(this).find('option:selected').text();

		var payment_gateway_id = $("#payment_gateway_id").val();

		if(payment_gateway_id == 3){
			//$("form").attr('id', 'givingsForm');
		}
		

		//alert(selectedText);		
		if (selectedText == "Others") {
			$("#dvSubPay").show();
			$('#sub_btn').show();
			$('#pay_btn').hide();
			$('#dvStripe').hide();
		} else {
			$("#dvSubPay").hide();
			$('#sub_btn').hide();
			$('#pay_btn').show();
			$('#dvStripe').show();
		
		}
	});
 });


 /////////
// An array of highlighting dates ( 'dd-mm-yyyy' )
setTimeout(function(){ 

    var selecteventdate = $(".selecteventdate").val();
    //alert(selecteventdate);
    if(selecteventdate){
        //alert(selecteventdate);
        //$('.selecteventdate').datepicker().change(eventDateChanged);
        //$('.selecteventdate').datepicker().click();
        $(".selecteventdate").datepicker("setDate", "<?php echo isset($crudGiving) ? $crudGiving->event_date : '';?>").change(eventDateChanged);

        //call team dropdown
        $('#btnAssignFlag').trigger('click');

    }
}, 1000);

  

$(document).ready(function(){
       
	var today               = new Date();
	var today_formatted     = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+('0'+today.getDate()).slice(-2);
	var user_busy_days      = <?php echo json_encode(array_unique((array_column($upcoming_events, 'eventCreatedDate'))));?>;//['2019-11-09','2019-11-16','2019-11-19'];
	//console.log(user_busy_days);
	$('.selecteventdate').datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd',
		inline: true,
		sideBySide: true,
		beforeShowDay: function (date) {

			calender_date = date.getFullYear()+'-'+('0'+date.getMonth()+1).slice(-2)+'-'+('0'+date.getDate()).slice(-2);

			var search_index = $.inArray(calender_date, user_busy_days);

			if (search_index > -1) {
				return {classes: 'non-highlighted-cal-dates', tooltip: 'User available on this day.'};
			}else{
				return {classes: 'highlighted-cal-dates', tooltip: 'User not available on this day.'};
			}

		}
		//datesDisabled: ['11/20/2019'],
	   // datesEnabled: ['11/22/2019'],
		
	}).change(eventDateChanged);

});
</script>


<link href="{{ URL::asset('css/custom_page.css') }}" rel="stylesheet" type="text/css" />


@endsection