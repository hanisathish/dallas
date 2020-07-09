@extends('layouts.default')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item active">Payment Gateways Management</li>
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

                <!-- <h4 class="mt-0 header-title">Location  <button type="button" class="btn btn-danger" onclick="addLocation()">Add New</button></h4> -->

                <!-- <button type="button" class="btn btn-primary waves-effect waves-light" id="alertify-labels">Click me</button> -->

                <!-- -->
                <table id="paymentGatewayTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Gateway Name</th>
                            <th>Active</th>
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

        paymentGatewayTable = $('#paymentGatewayTable').DataTable({
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
                url: siteUrl + '/settings/payment_gateways/list',
            },
            columns: [
                            {data: 'gateway_name', name: 'gateway_name'},
                            {data: 'active_status', name: 'active'},
                            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "initComplete": function(settings, json) {
               
            }
        });
    }
	
</script>

@endsection
