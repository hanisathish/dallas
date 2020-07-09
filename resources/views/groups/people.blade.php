@extends('layouts.default')

@section('content')
    <div style="width:100vw">
        <div class="row">
            <div class="col-md-12 p-3" style="background-color:#4d5467">
                <div class="card-body">
                    <h4 class="text-white">Peoples List</h4>  
                </div>
            </div>
        </div>
        <div class="row p-3 groupSortable" style="position:relative">
            
        </div>
    </div>

    <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                            
                            <table id="people_datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Groups</th>
                                    </tr>
                                </thead>
                                 
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

<script type="text/javascript">
    
    

$(function () {
    load_people_datatable();
    load_admin_datatable();
    
});    
    var people_datatable;
    var people_datatable_datastring = {admindatatable: 2};
    
    function load_people_datatable() {
        people_datatable = $('#people_datatable').DataTable({
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
                data: people_datatable_datastring,
                url: siteUrl + '/groups/people/list',
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