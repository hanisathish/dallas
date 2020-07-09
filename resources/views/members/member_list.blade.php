@extends('layouts.default')

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success" role="alert">
        {{ session()->get('message') }}
    </div>
@endif
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item active">Member Directory</li>
                </ol>
            </div>
            <!--<h4 class="page-title">Member Directory</h4>-->
            <a href="{{URL::asset('people/member/management')}}" type="button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-plus"></i>Add Person</a>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">

                <h4 class="mt-0 header-title">Member Directory</h4>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#allusers" role="tab">All</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#administrator" role="tab">Administrator</a>
                    </li>                                    
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active p-3" id="allusers" role="tabpanel">
                        <table id="userdatatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>First Name/ Last Name</th>
                                    <th>E-Mail Address</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>


                             
                        </table>
                    </div>
                    <div class="tab-pane p-3" id="administrator" role="tabpanel">
                        <table id="admin_datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>First Name/ Last Name</th>
                                    <th>E-Mail Address</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>


                            
                            
                        </table>
                    </div>

                </div>



            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<script type="text/javascript">
    
    

$(function () {
    load_userdatatable();
    load_admin_datatable();
    
});    
    var userdatatable;
    var userdatatable_datastring = {admindatatable: 2};
    
    function load_userdatatable() {
        userdatatable = $('#userdatatable').DataTable({
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
                type: "GET",
                data: userdatatable_datastring,
                url: siteUrl + '/get_usermaster_data',
            }
        });

    }
    
    
    var admin_datatable;
    
    var admin_datatable_datastring = {role_tag: "admin", admindatatable: "1"};
    
    function load_admin_datatable() {
        
        admin_datatable = $('#admin_datatable').DataTable({
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
                type: "GET",
                data: admin_datatable_datastring,
                url: siteUrl + '/get_usermaster_data',
            }
        });

    }
    
    
    
</script>    
@endsection
