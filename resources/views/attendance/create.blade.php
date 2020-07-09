@extends('layouts.default')

@section('content')
<div style="width:100vw">
    @include('attendance.header')

    <?php
        $formUrl = "/attendance/store";
        $event_attedance_id = isset(request()->route()->parameters['event_attedance_id'])? request()->route()->parameters['event_attedance_id'] : null;
        if($event_attedance_id){
            //$formUrl = $formUrl ."/". $event_attedance_id;
        }
    ?>
    <div class="row">
        <div class="col-sm-0 col-md-1 col-lg-2"></div>
        <div class="col-sm-12 col-md-10 col-lg-8 card">
            <!-- <div class="card m-b-30"> -->
            <div class="card-body pl-0 pr-0">
                <h5 class="mt-0 pl-3"> {{($event_attedance_id)? 'Edit' : "Create" }} Attendance </h5>
                <hr />
                <div class="row p0 m-0">
         {!! Form::open(array('id'=>'eventsAttendanceForm','name'=>'eventsAttendanceForm','method' => 'post', 'url' => $formUrl, 'class' => 'eventsAttendanceForm col-sm-12 card p-2','files' => true)) !!}
                    					    
						<input type="text" id="orgId" name="orgId" value="{{$orgId}}" class="d-none">
						 						

                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30">
                                    <div class="card-body">
									
											<div class="form-group row">
												<label for="example-date-input" class="col-sm-2 col-form-label">Event Date</label>
												<div class="col-sm-10">
													<input class="form-control selecteventdate" type="text" value="{{ old('event_date', isset($crudEventAttendance) ? $crudEventAttendance->event_date : '') }}" name="event_date" id="example_date_input">

		<input class="form-control" type="hidden" value="{{ old('event_id_hidden', isset($crudEventAttendance) ? $crudEventAttendance->event_id : '') }}" name="event_id_hidden"  id="event_id_hidden">
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
											
										   
										   <div class="form-group row">
											<label for="example-date-input" class="col-sm-2 col-form-label">Users</label>
											<div class="col-sm-10">
											<select class="form-control" name="user_id" id="user_id">
											   <option value="">--Select--</option>
										          @foreach($user_id as $user) 
												     <option value="{{ $user->id }}" @if(isset($crudEventAttendance)&& $user->id == $crudEventAttendance->user_id) selected @endif>{{ $user->full_name }}</option>														 
												  @endforeach												                                
											</select>
											</div>
										   </div>
										   
										  <div id="dvUser" style="display: block"> 
										   <div class="form-group row">
												<label for="example-text-input" class="col-sm-2 col-form-label">First Name</label>
												<div class="col-sm-10">
													<input class="form-control" type="text" value="{{ old('first_name', isset($crudEventAttendance) ? $crudEventAttendance->first_name : '') }}" id="first_name" 
													name="first_name" >
												</div>
                                           </div>

                                           <div class="form-group row">
												<label for="example-text-input" class="col-sm-2 col-form-label">Gender</label>
												<div class="col-sm-10">
													<select class="form-control" name="gender" id="gender">
														<option value="Male" <?= isset($crudEventAttendance)?($crudEventAttendance->gender=='Male')?'selected':'':'' ?>>Male</option>
														<option value="Female" <?= isset($crudEventAttendance)?($crudEventAttendance->gender=='Female')?'selected':'':'' ?>>Female</option>
												   </select>
												</div>
                                           </div>					   
                                          </div>
										  
                         					
										   
										   <div class="form-group row">
												<label for="example-text-input" class="col-sm-2 col-form-label">Attendance</label>
												<div class="col-sm-10">
													<input type="text" class="form-control datepicker-autoclose" name="attendance_date" id="attendance_date" placeholder="mm/dd/yyyy" value="{{ old('attendance_date', isset($crudEventAttendance) ? $crudEventAttendance->attendance_date : '') }}">
                                                     <!-- <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div> -->
												</div>
                                           </div>
										   
										
											<div class="form-group">
											    <input type="hidden" name="eventattedanceId" value="{{ isset($event_attedance)?$event_attedance->id:'' }}" />
												<div>
													<button type="submit" class="btn btn-primary waves-effect waves-light">
														Submit
													</button>
													<a href="{{ URL::asset('attendance')}}" type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</a>
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

<script type='text/javascript'>

$(document).ready(function() {
    $userid = $("#user_id").val();
	if($userid =="")
	{ 
        $("#dvUser").show();
		
	} else 
	{
		$("#dvUser").hide();
	}
	
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
 
 
 /////////
// An array of highlighting dates ( 'dd-mm-yyyy' )
setTimeout(function(){ 

    var selecteventdate = $(".selecteventdate").val();
    //alert(selecteventdate);
    if(selecteventdate){
        //alert(selecteventdate);
        //$('.selecteventdate').datepicker().change(eventDateChanged);
        //$('.selecteventdate').datepicker().click();
        $(".selecteventdate").datepicker("setDate", "<?php echo isset($crudEventAttendance) ? $crudEventAttendance->event_date : '';?>").change(eventDateChanged);

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

<script type="text/javascript" src="{{ URL:: asset('js/custom/event_attedance.js')}}"></script>

@endsection