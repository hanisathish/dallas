@extends('layouts.default')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item active">Organization Management</li>
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

                <h4 class="mt-0 header-title">Organization  <button type="button" class="btn btn-danger" onclick="addOrganization()">Add New</button></h4>
                <!-- -->
                <table id="organizationTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Organization Name</th>
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

        organizationTable = $('#organizationTable').DataTable({
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
                url: siteUrl + '/settings/organization/list',
            },
            columns: [
                            {data: 'orgName', name: 'orgName'},
                            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "initComplete": function(settings, json) {
                // $("#eventsTable_filter").append('<button class="btn small btn-primary" id="eventDateSearch"  >Event Date</button>');

            }
        });
    }

    function addOrganization(){
        addLocationDlg = BootstrapDialog.show({
                    title:"Create Organization",
                    size:"size-wide",
                    message: $('<div></div>').load(siteUrl+"/settings/organization/addOrganization"),
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
                        organizationTable.draw(false);
                    },2000);
                });

                $("#formSubmitBtn").click();
            }

function editOrganization(organizationId) {
	
    addLocationDlg = BootstrapDialog.show({
    title:"Update Organization",
    size:"size-wide",
    message: $('<div></div>').load(siteUrl+"/settings/organization/edit/"+organizationId),
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

</script>

@endsection
