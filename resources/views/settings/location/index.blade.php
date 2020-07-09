@extends('layouts.default')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item active">Location Management</li>
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

                <h4 class="mt-0 header-title">Location  <button type="button" class="btn btn-danger" onclick="addLocation()">Add New</button></h4>

                <!-- <button type="button" class="btn btn-primary waves-effect waves-light" id="alertify-labels">Click me</button> -->

                <!-- -->
                <table id="locationTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Lat</th>
                            <th>Lang</th>
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
        loadLocationDatatable();
    });

    function loadLocationDatatable() {

        locationTable = $('#locationTable').DataTable({
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

            }],
            "ajax": {
                type: "POST",
                data: {},
                url: siteUrl + '/settings/location/list',
            },
            columns: [
                            {data: 'name', name: 'name'},
                            {data: 'latitude', name: 'latitude'},
                             {data: 'longitude', name: 'longitude'},
                            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "initComplete": function(settings, json) {
                // $("#eventsTable_filter").append('<button class="btn small btn-primary" id="eventDateSearch"  >Event Date</button>');

            }
        });
    }

    function addLocation(){
        addLocationDlg = BootstrapDialog.show({
                    title:"Create Location",
                    size:"size-wide",
                    message: $('<div></div>').load(siteUrl+"/settings/location/addPage"),
                    buttons: [
                        {
                            label: 'Submit',
                            cssClass: 'btn-primary',
                            action: function(dialogRef){
                                submitCreateLocation();
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


            function submitCreateLocation(){

                $('#create_location_form').ajaxForm(function(data) {
                $("#create_location_form_status").html(data.message);
                setTimeout(function(){
                    addLocationDlg.close();
                        locationTable.draw(false);
                    },2000);
                });

                //$("#create_resource_form").submit();
                $("#formSubmitBtn").click();
            }

function editLocation(locarionId){
    addLocationDlg = BootstrapDialog.show({
    title:"Update Location",
    size:"size-wide",
    message: $('<div></div>').load(siteUrl+"/settings/location/edit/"+locarionId),
    buttons: [
        {
            label: 'Submit',
            cssClass: 'btn-primary',
            action: function(){
                submitCreateLocation();
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


    $(document).ready(function() {



    });



</script>

@endsection
