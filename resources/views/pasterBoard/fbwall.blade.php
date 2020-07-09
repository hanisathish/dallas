@extends('layouts.default')

@section('content')
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group pull-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item active">Pastors Board</li>
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
                                    <a href="{{URL::asset('settings/asset_management/resources')}}" class="btn btn-primary btn-lg btn-block">Manage Board</a>
                                    <a href="{{URL::asset('settings/asset_management/rooms')}}" class="btn btn-primary btn-lg btn-block">Board Wall</a>
                                    </div>
                            </div>
                        </div>
                    </div>
            <div class="col-lg-9">
                        <div class="row">
                      
  
                    <div class="col-lg-12">
                        <div class="card m-b-5">
                            <div class="card-header bg-warning">
                                Post  title goes here
                            </div>
                            <div class="card-body">
                                
                                <div class="media">
                                    <?php $profile_pic_image= url('/assets/uploads/organizations/avatar.png');?>
                                    <img class="d-flex mr-3 rounded-circle" src="{{$profile_pic_image}}" alt="Generic placeholder image" height="128">
                                    <div class="media-body">
                                        <h5 class="mt-0 font-18 mb-1">John B. Roman</h5>
                                        <p class="text-muted font-14">Webdeveloper</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> <!-- end col -->

                    <!-- second -->
                    <div class="col-lg-12">
                        <div class="card m-b-5">
                            <div class="card-header bg-success">
                                Ads title goes here
                            </div>
                            <div class="card-body">
                                <blockquote class="card-bodyquote">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere
                                        erat a ante.</p>
                                    <footer>Someone famous in <cite title="Source Title">Source Title</cite>
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <!-- second ends -->
                    <!-- second -->
                    <div class="col-lg-12">
                        <div class="card m-b-5">
                            <div class="card-header bg-primary">
                                News Feed title goes here
                            </div>
                            <div class="card-body">
                                <blockquote class="card-bodyquote">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere
                                        erat a ante.</p>
                                    <footer>Someone famous in <cite title="Source Title">Source Title</cite>
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <!-- second ends -->
                </div> <!-- end row -->
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



