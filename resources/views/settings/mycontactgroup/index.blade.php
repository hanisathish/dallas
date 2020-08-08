@extends('layouts.default')


@section('content')
<!-- Create MyContact Header -->
<div class="block-header">
    <!-- If you do not want a link in the header, instead of .header-title-link you can use a div with the class .header-section -->
    <a href="" class="header-title-link">
        <h1>
            <i class="fa fa-tint animation-expandUp"></i>MyContact<br><small></small>
        </h1>
    </a>
</div>
<ul class="breadcrumb breadcrumb-top">
    <li><i class="fa fa-th"></i></li>
    <li>Home</li>
    <li><a href="">MyContact</a></li>
</ul>
<div class="block">

    <div class="block-title">
        <h2>Groups</h2>
    </div>

    <div class="clearfix">
        <div class="pull-left">
            <a href="{{ route('mycontact.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Group</a>
        </div>
    </div>
    <div class="table-responsive">
                        <table id="mygroups-datatable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Group Name</th>
                                    <th>No of Contacts</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                 
                                
                            </tbody>
                        </table>
                    </div>

</div>
    <div class="clearfix"></div>

<div class="block">

    <div class="block-title">
        <h2>My Contacts</h2>
    </div>    
<div class="table-responsive">
                        <table id="mycontacts-datatable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Email</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Groups</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                 
                                
                            </tbody>
                        </table>
                    </div>
                        
                    </div>    
    @section('js_script')


     <!-- Javascript code only for this page -->


            <script>

                $(function () {
                    loadMyContactDatatable();
                });

                function loadMyContactDatatable() {
                    // webApp.datatables();
                    meetingTable = $('#mycontacts-datatable').DataTable({
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
                            "visible": false
                        }],
                        pageLength: 15,
                        lengthMenu: [[15, 20, 50, -1], [15, 20, 50, "All"]],
                        "ajax": {
                            type: "POST",
                            data: {},
                            url: siteUrl + '/settings/mycontact/list',
                        },
                        "initComplete": function(settings, json) {
                            // $("#eventsTable_filter").append('<button class="btn small btn-primary" id="eventDateSearch"  >Event Date</button>');

                        }
                    });

                    /* Add placeholder attribute to the search form */
                    $('.dataTables_filter input').attr('placeholder', 'Search');
                }

                // $(function () {
                

                //     webApp.datatables();

                

                //     $('#mycontacts-datatable').dataTable({
                //         columnDefs: [{orderable: false, targets: [4]}],
                //         pageLength: 15,
                //         lengthMenu: [[15, 30, 50, -1], [15, 30, 50, "All"]]
                //     });

                

                //     $('.dataTables_filter input').attr('placeholder', 'Search');
                // });

  
            </script>

    @endsection

@endsection