@extends('layouts.default')

@section('content')
<?php //echo "sssss".date('Y-m-d',strtotime("05/22/2020")); exit; ?>
    <div style="width:100vw">
        @include('attendance.header')
        <div class="row m-5 pl-4 pr-4">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h5 class="mt-0">Events Attendance List<a href="{{ URL:: asset('attendance/manage/')}}" class="btn btn-sm btn-success pull-right text-white"><i class="fa fa-plus"></i> Create New</a></h5>
                        <hr/>
						<div class="row" style="margin-left: 85px;">
							<div class="form-group row">
								<label for="example-text-input" class="col-sm-4 col-form-label">Start Date</label>
								<div class="col-sm-5">
									<input type="text" class="form-control datepicker-autoclose" name="start_date" id="start_date" placeholder="mm/dd/yyyy" value="">
									  <!--<div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>-->
								</div>
							</div>
							
							<div class="form-group row">
								<label for="example-text-input" class="col-sm-4 col-form-label">End Date</label>
								<div class="col-sm-5">
									<input type="text" class="form-control datepicker-autoclose" name="end_date" id="end_date" placeholder="mm/dd/yyyy" value="">
									 <!--<div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>-->
								</div>
							</div>
							
							<div class="form-group row">
								<label for="example-date-input" class="col-sm-4 col-form-label">Events</label>
								<div class="col-sm-8">
								<select class="form-control" name="event_id" id="event_id">
								   <option value="">--Select--</option>
									  @foreach($crudEvents as $events) 
										 <option value="{{ $events->eventId }}">{{ $events->eventName }}</option>														 
									  @endforeach												                                
								</select>
								</div>
							</div>
										   
							
							<div class="text-left" style="margin-left: 15px;"><button type="text" id="btnFiterSubmitSearch" class="btn btn-info">Submit</button></div>
	
						</div>
                        
						<div class="tab-content">
                            <div class="tab-pane active p-3">
                                <table id="scheduleDatatable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>				
                                            <th>Org Name</th>						
											<th>Events</th>											
											<th>User FullName</th> 
											<th>Gender</th> 
											<th>Attendance Date</th> 
                                            <th>Action</th>											
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="{{ URL:: asset('js/attendance/index.js')}}"></script>
	
<script>
	//Delete the data
function attendance_data_delete(eventattedanceId)
{	
    alertify.confirm("Are you sure you want to delete?", function (asc) {
         if (asc) {
             //ajax call for delete    
             var dataString = 'eventattedanceId=' + eventattedanceId;
             $.ajax({
                url: siteUrl + '/attendance/eventattedance_data_delete',
                async: true,
                type: "GET",
                data: dataString,
                dataType: "html",
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    location.reload();
                }
            });   
             alertify.success("Record is deleted.");

         } else {
             alertify.error("You've clicked cancel");
         }
     },"Default Value");
}
</script>
	
@endsection