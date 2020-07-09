@extends('layouts.default')

@section('content')
<div style="width:100vw">
    @include('settings.schedule.header')

    <?php
        $formUrl = "/settings/schedulling/store";
        $schedule_id = isset(request()->route()->parameters['schedule_id'])? request()->route()->parameters['schedule_id'] : null;
        if($schedule_id){
            //$formUrl = $formUrl ."/". $schedule_id;
        }
    ?>
    <div class="row">
        <div class="col-sm-0 col-md-1 col-lg-2"></div>
        <div class="col-sm-12 col-md-10 col-lg-8 card">
            <!-- <div class="card m-b-30"> -->
            <div class="card-body pl-0 pr-0">
                <h5 class="mt-0 pl-3"> {{($schedule_id)? 'Edit' : "Create" }} Schedule</h5>
                <hr />
                <div class="row p0 m-0">
                    {!! Form::open(array('id'=>'scheduleForm','name'=>'scheduleForm','method' => 'post', 'url' => $formUrl, 'class' => 'col-sm-12 card p-2','files' => true)) !!}
                    
                    <!-- <form method="post" action="{{ route('settings.schedulling.store') }}" name="scheduleForm" id="scheduleForm" enctype="multipart/form-data" class="col-sm-12 card p-2"> -->
                        <input type="text" id="scheduleId" name="scheduleId" value="{{$schedule_id}}" class="d-none">
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30">
                                    <div class="card-body">

                                        <!-- <h4 class="mt-0 header-title">Textual inputs</h4>
                                <p class="text-muted m-b-30 font-14">Here are examples of <code
                                        class="highlighter-rouge">.form-control</code> applied to each
                                    textual HTML5 <code class="highlighter-rouge">&lt;input&gt;</code> <code
                                            class="highlighter-rouge">type</code>.</p> -->

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ old('title', isset($crudSchedule) ? $crudSchedule->title : '') }}" id="title" name="title" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-date-input" class="col-sm-2 col-form-label">Event Date</label>
                                            <div class="col-sm-10">
                                                <input class="form-control selecteventdate" type="text" value="{{ old('event_date', isset($crudSchedule) ? $crudSchedule->event_date : '') }}" name="event_date" id="event_date">

                                                <input class="form-control" type="hidden" value="{{ old('event_id_hidden', isset($crudSchedule) ? $crudSchedule->event_id : '') }}" name="event_id_hidden" id="event_id_hidden">
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
                                            <label class="col-sm-2 col-form-label">Notification Flag</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="notification_flag" id="notification_flag">
                                                    <option value="">--Select--</option>
                                                    <option value="1" <?= isset($crudSchedule)?($crudSchedule->notification_flag=='1')?'selected':'':'' ?>>None</option>
                                                    <option value="2" <?= isset($crudSchedule)?($crudSchedule->notification_flag=='2')?'selected':'':'' ?>>SMS</option>
                                                    <option value="3" <?= isset($crudSchedule)?($crudSchedule->notification_flag=='3')?'selected':'':'' ?>>Email</option>
                                                    <option value="4" <?= isset($crudSchedule)?($crudSchedule->notification_flag=='4')?'selected':'':'' ?>>Both</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Team</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="team_id" id="team_id">
                                                    <option value="">--Select-</option>
                                                    @foreach($team_id as $value)
                                                    
                                                    <option <?= isset($crudSchedule)?($crudSchedule->team_id==$value->id)?'selected':'':'' ?> value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-url-input" class="col-sm-2 col-form-label">Assign Type</label>
                                            <div class="col-sm-10">
                                                
                                                <div>
                                                    <!--class="btn-group btn-group-toggle" data-toggle="buttons"-->
                                                    <!-- <label class="btn btn-info  active"> -->
                                                    <label>
                                                        <input type="radio" name="is_manual_schedule" id="is_manual_schedule" autocomplete="off"  value="2" <?= isset($crudSchedule)?($crudSchedule->is_manual_schedule=="2")?'checked':'':'' ?>> Manual
                                                    </label>
                                                    <!-- <label class="btn btn-info "> -->
                                                    <label>
                                                        <input type="radio" name="is_manual_schedule" id="is_manual_schedule" autocomplete="off" value="1" <?= isset($crudSchedule)?($crudSchedule->is_manual_schedule=="1")?'checked':'':'' ?>> Auto
                                                    </label>

                                                    <button style="margin-left:50px;" type="button" class="btn btn-warning btnAssignFlag" id="btnAssignFlag" <i class="fa fa-check"></i> Assign</button>

                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-group row load_positions" id="load_positions">

                                        </div>

                                        <div class="form-group">
                                            <div>
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                    Submit
                                                </button>
                                                <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                    Cancel
                                                </button>
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
 /////////



 /////////
// An array of highlighting dates ( 'dd-mm-yyyy' )
setTimeout(function(){ 

    var selecteventdate = $(".selecteventdate").val();
    //alert(selecteventdate);
    if(selecteventdate){
        //alert(selecteventdate);
        //$('.selecteventdate').datepicker().change(eventDateChanged);
        //$('.selecteventdate').datepicker().click();
        $(".selecteventdate").datepicker("setDate", "<?php echo isset($crudSchedule) ? $crudSchedule->event_date : '';?>").change(eventDateChanged);

        //call team dropdown
        $('#btnAssignFlag').trigger('click');

    }
}, 1000);

  

$(document).ready(function(){
 
      
        var today               = new Date();
        var today_formatted     = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+('0'+today.getDate()).slice(-2);
        var user_busy_days      = <?php echo json_encode(array_unique((array_column($upcoming_events, 'eventCreatedDate'))));?>;//['2019-11-09','2019-11-16','2019-11-19'];



        $('.selecteventdate').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            inline: true,
            sideBySide: true,
            beforeShowDay: function (date) {

                calender_date = date.getFullYear()+'-'+('0'+date.getMonth()+1).slice(-2)+'-'+('0'+date.getDate()).slice(-2);

                var search_index = $.inArray(calender_date, user_busy_days);
                //console.log(calender_date,"===",user_busy_days);
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

<style type="text/css"> 


</style>
<link href="{{ URL::asset('css/custom_page.css') }}" rel="stylesheet" type="text/css" />

<script src="{{ URL:: asset('js/settings/schedule/schedule.js')}}"></script>
@endsection