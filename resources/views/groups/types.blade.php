@extends('layouts.default')

@section('content')
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group pull-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item active">Group Types</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title end breadcrumb -->

            <div class="row">

            <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <h4 class="mt-0 header-title">Group Types</h4>


                                <!-- -->
                                <div class="row">
                                <div class="button-items col-md-6">
                                    <button type="button" onclick="createGroupTypesDialog()" class="btn btn-primary waves-effect waves-light">Add Group Types</button>
                                </div>

                                </div>
                                <br>
                                <!-- -->
                                <table id="GroupTypesTable" class="table table-bordered">
                                    <thead>
                                    <tr>
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

                loadDatatable();


              // $("#eventDateSearch").
            });

                function loadDatatable(){
                    //var date = $('#eventDateSearch').datepicker('getFormattedDate',"yyyy-mm-dd");
                    GroupTypesTable = $('#GroupTypesTable').DataTable({
                        "serverSide": true,
                        "destroy": true,
                        "autoWidth": false,
                        "searching": true,
                        //"aaSorting": [[ 1, "desc" ]],
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
                            url: siteUrl + '/groups/types/groupTypesList',
                        }, //'eventId', 'eventName','eventDesc' , 'eventFreq', 'eventCreatedDate', 'eventCheckin', 'eventStartCheckin', 'eventEndCheckin','eventLocation'
                        columns: [
                            {data: 'action', name: 'action', orderable: false, searchable: false},
                        ],
                        "initComplete": function(settings, json) {
                          // $("#eventsTable_filter").append('<button class="btn small btn-primary" id="eventDateSearch"  >Event Date</button>');

                        }
                    });
                }


            function createGroupTypesDialog (){
                 createGroupTypesDlg = BootstrapDialog.show({
                    title:"New Group Type",
                    size:"size-wide",
                    message: $('<div></div>').load(siteUrl+"/groups/types/create_group_types_page"),
                    buttons: [
                        {
                            label: 'Submit',
                            cssClass: 'btn-primary',
                            action: function(dialogRef){
                                submitGroupTypes();
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

            function submitGroupTypes(){

                $('#create_group_type_form').ajaxForm(function(data) {
                   $("#create_group_type_form_status").html(data.message);
                   setTimeout(function(){
                    createGroupTypesDlg.close();

                    GroupTypesTable.draw(false);
                    },2000);
                });

                //$("#create_resource_form").submit();
                $("#formSubmitBtn").click();
            }

            function groupDefaults(title,groupTypeId){
                createGroupTypesDlg = BootstrapDialog.show({
                    title:title+" Default settings",
                    size:"size-wide",
                    message: $('<div></div>').load(siteUrl+"/groups/types/defaults/"+groupTypeId),
                    buttons: [
                        {
                            label: 'Submit',
                            cssClass: 'btn-primary',
                            action: function(){
                                submitGroupTypes();
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



