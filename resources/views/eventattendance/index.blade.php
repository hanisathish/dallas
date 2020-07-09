@extends('layouts.default')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item active">Event Attendance Management</li>
                </ol>
            </div>
            <!--<h4 class="page-title">Roles Management</h4>-->
            <!--<a href="{{URL::asset('role_create')}}" type="button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-plus"></i>Add Role</a>-->
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body">

                <h4 class="mt-0 header-title">Event Attendance <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-attendancecount">Add New</button></h4>

                <!-- <button type="button" class="btn btn-primary waves-effect waves-light" id="alertify-labels">Click me</button> -->
                
                <!-- -->
                <table id="insightTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Event Name</th>
                            <th>Organization Name</th>
                            <th>Male Count</th>
                            <th>Female Count</th>
                            <th>Action</th>
                    </thead>

                    <tbody>

                    </tbody>
                </table>


            </div>
        </div>
    </div> <!-- end col -->

</div> <!-- end row -->


<div class="modal fade bs-example-modal-center" id="modal-attendancecount" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    {!! Form::open(array('id'=>'attendanceCountCreateForm','name'=>'attendanceCountCreateForm','method' => 'post', 'url' => url('eventattendance_data_insert'), 'class' => '')) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title attendancecount_modal_title">Add Event Attendance</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body form-horizontal attendancecountbody">			
			
			    <?php
				/*$whereSchArray = array('id'=>2);
				$crudAttendanceCount = \App\Models\AttendanceCount::crudAttendanceCount($whereSchArray,null,null,null,null,null,null,'1')->get();
	
				if($crudAttendanceCount->count() > 0){
					$crudAttendanceCount = $crudAttendanceCount[0];
				}*/
				?>
                <div class="form-group no-bg">
                    <label for="" class="col-sm-10 control-label text_align_right" style="text-align: left !important;">Event Date</label>
                    <div class="col-sm-9">
                        <input type="hidden" name="hidden_attendanceCountID" id="hidden_attendanceCountID" value="" />
                        <input class="form-control selecteventdate" type="text" value="{{ old('event_date', isset($crudAttendanceCount) ? $crudAttendanceCount->event_date : '') }}" name="event_date" 
						id="event_date">
		        <input class="form-control" type="hidden" value="{{ old('event_id_hidden', isset($crudAttendanceCount) ? $crudAttendanceCount->event_id : '') }}" name="event_id_hidden"  
				id="event_id_hidden">
                    </div>
                </div>
				

				<div class="form-group no-bg">
					<label for="" class="col-sm-10 control-label text_align_right" style="text-align: left !important;">Select Event</label>
					<div class="col-sm-9 load_events" id="load_events">                        
						<select  name='event_id' id='event_id' class='form-control'>
						   <option value="">--Select--</option>                        
						</select>
					</div>
				</div>
			
				
				<div class="form-group no-bg">
                    <label for="" class="col-sm-10 control-label text_align_right" style="text-align: left !important;">Male Count</label>
                    <div class="col-sm-9">
                        <input class="form-control"  type="text" value="" id="male_count" name="male_count" >
                    </div>
                </div>
				
				
				<div class="form-group no-bg">
                    <label for="" class="col-sm-10 control-label text_align_right" style="text-align: left !important;">Female Count</label>
                    <div class="col-sm-9">
                         <input class="form-control"  type="text" value="" id="female_count" name="female_count">
                    </div>
                </div>
				
				
                <button type="button" class="btn btn-success margin pull-left" id="btnCreateattendanceCount">Save</button>
                <button type="button" class="btn btn-danger margin pull-right" data-dismiss="modal">Cancel</button>
                <div class="clear"></div>
            </div>
        </div><!-- /.modal-content -->
    {!! Form::close() !!}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 
<script>

	// An array of highlighting dates ( 'dd-mm-yyyy' )
	setTimeout(function(){ 

		var selecteventdate = $(".selecteventdate").val();
		//alert(selecteventdate);
		if(selecteventdate){
			//alert(selecteventdate);
			//$('.selecteventdate').datepicker().change(eventDateChanged);
			//$('.selecteventdate').datepicker().click();
			
			//$(".selecteventdate").datepicker("setDate", "<?php echo isset($crudAttendanceCount) ? $crudAttendanceCount->event_date : '';?>").change(eventDateChanged);
			
			$(".selecteventdate").datepicker("setDate", "<?php echo isset($crudAttendanceCount) ? $crudAttendanceCount->event_date : '';?>").change(eventDateChanged);

			//call team dropdown
			$('#btnAssignFlag').trigger('click');

		}
	}, 1000);


	$(document).ready(function() {
		
		loadAttendanceCountDatatable();
		
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
	

    function loadAttendanceCountDatatable() {

        insightTable = $('#insightTable').DataTable({
            "serverSide": true,
            "destroy": true,
            "autoWidth": false,
            "searching": true,
            "aaSorting": [
                [0, "desc"]
            ],
            "columnDefs": [{
                "targets": 0,
                "searchable": false,
                "visible": false
            }],
            "ajax": {
                type: "POST",
                data: {},
                url: siteUrl + '/eventattendance/list',
            },
            "initComplete": function(settings, json) {
                // $("#eventsTable_filter").append('<button class="btn small btn-primary" id="eventDateSearch"  >Event Date</button>');

            }
        });
    }


    $('#modal-attendancecount').on('hidden.bs.modal', function() {
        $(".attendancecount_modal_title").html('');
        $(".attendancecount_modal_title").html('Add Event Attendance');
        $('.attendancecountbody').find('select').val('');
        $('.attendancecountbody').find('input').val('');

        var $alertas = $('#attendanceCountCreateForm');
        $alertas.validate().resetForm();
        $alertas.find('.error').removeClass('error');
    });


    $(document).ready(function() {
        chkValidateStatus = "";
        chkValidateStatus = $("#attendanceCountCreateForm").validate({
            //ignore:[],// false,
            ignore: false,
            errorClass: "error",
            rules: {
				event_id: {
                    required: true
                },
                male_count: {
                    required: true
                },
				female_count: {
                    required: true
                }
            },
            messages: {
				event_id: {
                    required: "Please Select Event"
                },
                male_count: {
                    required: "Please enter Male Count"
                },
				female_count: {
                    required: "Please enter Female Count"
                }
            }
        });
    });



    //Save AttendanceCount details to the database

    $("#btnCreateattendanceCount").click(function() {
        
		//alert('submit');
		
        var formObj = $('#attendanceCountCreateForm');
        var formData = new FormData(formObj[0]);

        $("#attendanceCountCreateForm").valid();

        var errorNumbers = chkValidateStatus.numberOfInvalids();
		
        //alert(errorNumbers);
		
        if (errorNumbers == 0) {
            $.ajax({
                url: siteUrl + '/eventattendance_data_insert',
                async: true,
                type: "POST",
                data: formData,
                dataType: "html",
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
					console.log(data);
					
                    $('#modal-attendancecount').modal('hide');
                    if (data == "updated") {
                        //alert("AttendanceCount Updated");
                        //location.reload();
                        loadAttendanceCountDatatable();

                    } else if (data == "inserted") {
                        //alert("AttendanceCount Added");
                        //location.reload();
                        loadAttendanceCountDatatable();

                    } else {
                        alert("Error in Updation");
                        return false;
                    }
                }

            });

        } else {

        }
    });

    //form submission
    $('#attendanceCountCreateForm').submit(function(e) {
        var errorNumbers = chkValidateStatus.numberOfInvalids();
        if (errorNumbers == 0) {
            return true;
        } else {

        }
    });

    //Edit the edit_attendance_count data
    function edit_attendance_count(attendanceCountID) {
		
        //alert(attendanceCountID);
		
        $(".attendancecount_modal_title").html('');
        $(".attendancecount_modal_title").html('Edit Event Attendance');
        var dataString = 'attendanceCountID=' + attendanceCountID;

        $.ajax({
            url: siteUrl + '/eventattendance/get_event_attendance_by_id',
            async: true,
            type: "GET",
            data: dataString,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
                //location.reload();
				//alert(data.event_date);
                $('#modal-attendancecount').modal('show');
                $("#hidden_attendanceCountID").val(data.id);
                $("#event_date").val(data.event_date);
                $("#event_id_hidden").val(data.event_id);
                $("#male_count").val(data.male_count);
				$("#female_count").val(data.female_count);
				var ev = data.event_date;
				eventDateChangedEdit(ev);
					
				
            }
        });

    }

    
//Delete the insight data
function attendance_count_data_delete(attendanceCountId)
{
    
    alertify.confirm("Are you sure you want to delete?", function (asc) {
         if (asc) {
             //ajax call for delete    
             var dataString = 'attendanceCountId=' + attendanceCountId;

             $.ajax({
                url: siteUrl + '/eventattendance/eventattendance_data_delete',
                async: true,
                type: "GET",
                data: dataString,
                dataType: "html",
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    //location.reload();
                    loadAttendanceCountDatatable();

                }
            });   
             alertify.success("Record is deleted.");

         } else {
             alertify.error("You've clicked cancel");
         }
     },"Default Value");
 }


</script>

<script type="text/javascript" src="{{ URL:: asset('js/custom/attedance_count.js')}}"></script>

@endsection