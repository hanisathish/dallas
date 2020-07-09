@extends('layouts.default')

@section('content')
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group pull-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item active">Room Management</li>
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
                                    <a href="{{URL::asset('settings/asset_management/resources')}}" class="btn btn-primary btn-lg btn-block">Resources</a>
                                    <a href="{{URL::asset('settings/asset_management/rooms')}}" class="btn btn-primary btn-lg btn-block">Rooms</a>
                                    </div>
                            </div>
                        </div>
                    </div>
            <div class="col-lg-9">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <h4 class="mt-0 header-title">Rooms</h4>


                                <!-- -->
                                <div class="row">
                                <div class="button-items col-md-6">
                                    <button type="button" onclick="createRoomDialog()" class="btn btn-primary waves-effect waves-light">Create Room</button>
                                </div>

                                </div>
                                <br>
                                <!-- -->
                                <table id="roomsTable" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Rooms</th>
                                        <th>Action</th>
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

                loadDatatable();
                $("#item_year").datepicker({
                    format: "yyyy",
                    viewMode: "years",
                    minViewMode: "years"
                });


              // $("#eventDateSearch").
            });

                function loadDatatable(){
                    //var date = $('#eventDateSearch').datepicker('getFormattedDate',"yyyy-mm-dd");
                    roomsTable = $('#roomsTable').DataTable({
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
                            data: {},
                            url: siteUrl + '/rooms/list',
                        }, //'eventId', 'eventName','eventDesc' , 'eventFreq', 'eventCreatedDate', 'eventCheckin', 'eventStartCheckin', 'eventEndCheckin','eventLocation'
                        columns: [
                            {data: 'image', name: 'image', orderable: false, searchable: false},
                            {data: 'room_name', name: 'room_name'},
                             {data: 'group_name', name: 'mldValue'},
                            {data: 'action', name: 'action', orderable: false, searchable: false},
                        ],
                        "initComplete": function(settings, json) {
                          // $("#eventsTable_filter").append('<button class="btn small btn-primary" id="eventDateSearch"  >Event Date</button>');

                        }
                    });
                }


            function createRoomDialog(){
                 createRoomDlg = BootstrapDialog.show({
                    title:"Create Room",
                    size:"size-wide",
                    message: $('<div></div>').load(siteUrl+"/rooms/create_page"),
                    buttons: [
                        {
                            label: 'Submit',
                            cssClass: 'btn-primary',
                            action: function(dialogRef){
                                submitCreateRoom();
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

            function submitCreateRoom(){

                $('#create_room_form').ajaxForm(function(data) {
                   $("#create_room_form_status").html(data.message);
                   setTimeout(function(){
                    createRoomDlg.close();
                        roomsTable.draw(false);
                    },2000);
                });

                //$("#create_resource_form").submit();
                $("#formSubmitBtn").click();
            }

            function editRoom(roomId){
                createRoomDlg = BootstrapDialog.show({
                    title:"Update Room",
                    size:"size-wide",
                    message: $('<div></div>').load(siteUrl+"/rooms/edit/"+roomId),
                    buttons: [
                        {
                            label: 'Submit',
                            cssClass: 'btn-primary',
                            action: function(){
                                submitCreateRoom();
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


                    </script>

@endsection



