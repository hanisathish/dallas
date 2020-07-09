@extends('layouts.default')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item active">Payment Management</li>
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

                <h4 class="mt-0 header-title">Payment Others <a class="nav-link" href="payment_others/addPaymentPage"><i class="fa fa-lg"></i>Add New</a></h4>

              
                <table id="paymentTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Payment Method</th>
                            <th>Payment Method Notes</th>
                            <th>Status</th>
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
        loadPaymentDatatable();
    });

    function loadPaymentDatatable() {

        paymentTable = $('#paymentTable').DataTable({
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
                url: siteUrl + '/settings/payment_others/list',
            },
            columns: [
                            {data: 'payment_method', name: 'payment_method'},
                            {data: 'payment_method_notes', name: 'payment_method_notes'},
                             {data: 'status', name: 'status'},
                            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "initComplete": function(settings, json) {
                
            }
        });
    }
	
</script>

@endsection
