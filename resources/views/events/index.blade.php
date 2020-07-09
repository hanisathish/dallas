@extends('layouts.default')

@section('content')
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group pull-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item active">Events</li>
                            </ol>
                        </div>
                        <!--<h4 class="page-title">Roles Management</h4>-->
                        <!--<a href="{{URL::asset('role_create')}}" type="button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-plus"></i>Add Role</a>-->
                    </div>
                </div>
            </div>
            <!-- end page title end breadcrumb -->

            <div class="row">
                    <div class="col-lg-3">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="button-items">
                                    <a href="{{URL::asset('events')}}" class="btn btn-primary btn-lg btn-block">Room Availability</a>
                                    <a href="{{URL::asset('events')}}" class="btn btn-primary btn-lg btn-block">Notification</a>
                                    </div>
                            </div>
                        </div>
                    </div>
            <div class="col-lg-9">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <h4 class="mt-0 header-title">Events</h4>


                                <!-- -->
                                <div class="row">
                                <div class="button-items col-md-6">
                                    <button type="button" onclick="createEventDialog()" class="btn btn-primary waves-effect waves-light">Create Event</button>




                                </div>
                                <div class=" col-md-6 ">

                                    <div class="input-group">
                                        <input class="form-control col-md-6 " type="search"   value=""  id="eventDateSearch" autocomplete="off" />
                                        <span class="input-group-btn" style="padding-left: 10px;">
                                             <button type="button" onclick="loadDatatable()" class="btn btn-primary waves-effect waves-light">Search</button>
                                        </span>
                                     </div>



                                </div>
                                </div>
                                <br>
                                <!-- -->
                                <table id="eventsTable" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>


                                    <tbody>

                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div> <!-- end col -->




            </div> <!-- end row -->

            <script>

             $(document).ready(function() {
                initDatePicker();
                loadDatatable();



              // $("#eventDateSearch").
            });

                function loadDatatable(){
                    var date = $('#eventDateSearch').datepicker('getFormattedDate',"yyyy-mm-dd");
                    if($('#eventDateSearch').val()==""){
                        date = "";
                    }

                    eventsTable = $('#eventsTable').DataTable({
                        "serverSide": true,
                        "destroy": true,
                        "autoWidth": false,
                        "searching": true,
                        "aaSorting": [[ 1, "desc" ]],
                        "columnDefs": [
                            {
                                "targets": 0,
                                "searchable": false,
                                "visible" : true
                                }
                            ],
                        "ajax": {
                            type: "POST",
                            data: {date:date},
                            url: siteUrl + '/events/list',
                        }, //'eventId', 'eventName','eventDesc' , 'eventFreq', 'eventCreatedDate', 'eventCheckin', 'eventStartCheckin', 'eventEndCheckin','eventLocation'
                        columns: [
                            {data: 'eventName', name: 'eventName'},
                            {data: 'eventCreatedDate', name: 'eventCreatedDate'},
                             {data: 'eventStartCheckin', name: 'eventStartCheckin'},
                              {data: 'eventEndCheckin', name: 'eventEndCheckin'},
                            {data: 'action', name: 'action', orderable: false, searchable: false},
                        ],
                        "initComplete": function(settings, json) {
                          // $("#eventsTable_filter").append('<button class="btn small btn-primary" id="eventDateSearch"  >Event Date</button>');

                        }
                    });
                }
                function initDatePicker(){
                      $('#eventDateSearch').datepicker({
                     "format":"dd/mm/yyyy"
                 });
                $('#eventDateSearch').datepicker()
                .on("changeDate", function(e) {
                     $('#eventDateSearch').datepicker('hide');
                    //console.log(e);
            var date = $('#eventDateSearch').datepicker('getFormattedDate',"yyyy-mm-dd");
                    // `e` here contains the extra attributes
            //eventsTable.search(date).draw(false);
                });
                }

            function createEventDialog(){
                 CreateEventsDlg = BootstrapDialog.show({
                    title:"Create Event",
                    size:"size-wide",
                    message: $('<div></div>').load(siteUrl+"/events/create_page"),
                    buttons: [
                        {
                            label: 'Submit',
                            cssClass: 'btn-primary',
                            action: function(dialogRef){
                                submitCreateEvent();
                            }
                        },
                        {
                            label: 'Cancel',
                            action: function(dialogRef){
                                dialogRef.close();
                            }
                        }
                    ]
                });
            }

            function submitCreateEvent(){

                $('#create_event_form').ajaxForm(function(data) {
                   $("#create_event_form_status").html(data.message);
                   setTimeout(function(){
                       CreateEventsDlg.close();
                        eventsTable.draw(false);
                    },2000);
                });

                //$("#create_event_form").submit();
                $("#formSubmitBtn").click();
            }

            function editEvents(eventId){
                CreateEventsDlg = BootstrapDialog.show({
                    title:"Update Event",
                    size:"size-wide",
                    message: $('<div></div>').load(siteUrl+"/events/edit/"+eventId),
                    buttons: [
                        {
                            label: 'Submit',
                            cssClass: 'btn-primary',
                            action: function(){
                                submitCreateEvent();
                            }
                        },
                        {
                            label: 'Cancel',
                            action: function(dialogRef){
                                dialogRef.close();
                            }
                        }
                    ]
                });
            }

            function validateTime(elm){

                //$(".create-time option").attr("disabled",false);

                if(elm.id=="eventStartCheckin"){
                    var index = $("#eventStartCheckin option:selected").index();
                    $("#eventEndCheckin option").eq(0).prop('selected', true);
                    $("#eventShowTime option").eq(0).prop('selected', true);

                    $("#eventEndCheckin option").attr("disabled",false);
                    $("#eventShowTime option").attr("disabled",false);

                    $("#eventEndCheckin option:lt("+(index+1)+")").attr('disabled',true);
                    $("#eventShowTime option:gt("+(index-2)+")").attr('disabled',true);
                }
                if(elm.id=="eventEndCheckin"){
                    var index = $("#eventEndCheckin option:selected").index();

                    $("#eventShowTime option").eq(0).prop('selected', true);

                     $("#eventShowTime option").attr("disabled",false);
                    $("#eventShowTime option:gt("+(index-1)+")").attr('disabled',true);
                }
                if(elm.id=="eventShowTime"){

                }
            }
                    </script>

@endsection



