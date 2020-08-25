@extends('layouts.default')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item active">My Contact Management</li>
                </ol>
            </div>            
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">

                <h4 class="mt-0 header-title">Contact Groups</h4>
                 

                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Group Name</label>
                    <div class="col-sm-3">
                        <input type="text" id="group_name" name="group_name" class="form-control" required>
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-md btn-primary addGroup" id="addGroup"><i class="fa fa-plus"></i> Add Group</button>
                        <a href="{{ route('bulkupload.index') }}"   class="btn btn-md btn-warning"   data-original-title="Add Contact"><i class="fa fa-upload"></i>  Bulk Upload Contact</a>
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
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<div class="clearfix"></div>

<div class="row" style="display: none;">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">

                <h4 class="mt-0 header-title">My Contacts</h4>
                 

                <a href="{{ route('mycontact.create') }}"   class="btn btn-md btn-primary"   data-original-title="Add Contact"><i class="fa fa-plus"></i>  Add Contact</a>

                <a href="{{ route('bulkupload.index') }}"   class="btn btn-md btn-warning"   data-original-title="Add Contact"><i class="fa fa-upload"></i>  Bulk Upload Contact</a>

                  
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                          
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
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@include('common.modal')
                                

    @section('js_script')
        <script>

            $(function () {
                loadMyContactGroupDatatable();
            });

            function loadMyContactGroupDatatable() {
                
                // //webApp.datatables();
                meetingTable = $('#mygroups-datatable').DataTable({
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
                        url: siteUrl + '/settings/mycontactgroup/list',
                    },
                    "initComplete": function(settings, json) {
                        // $("#eventsTable_filter").append('<button class="btn small btn-primary" id="eventDateSearch"  >Event Date</button>');

                    }
                });

                /* Add placeholder attribute to the search form */
                $('.dataTables_filter input').attr('placeholder', 'Search');
            }


            $(function () {
                loadMyContactDatatable();
            });

            function loadMyContactDatatable() {
                //webApp.datatables();
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
 
            
            $("#addGroup").click(function () {

                var datastring = "group_name="+$("#group_name").val();
                //alert(datastring);
                $.ajax({
                    url: siteUrl + '/settings/mycontactgroup/store',
                    async: true,
                    type: "POST",
                    data: datastring,
                    dataType: "html",
                    // contentType: false,
                    // cache: false,
                    // processData: false,
                    success: function (data)
                    {
                        $("#group_name").html('');
                        $("#group_name").val('');
                        loadMyContactGroupDatatable();
                    }

                });                
            });

            $('#modal-mycontactgroup').on('show.bs.modal', function (event) {
                  var button = $(event.relatedTarget) // Button that triggered the modal
                  var groupname = button.data('groupname') 
                  var groupid = button.data('groupid') 

                  var modal = $(this)
                  modal.find('.modal-title').text('Edit Group -' + groupname)
                  modal.find('#addContactsPopGroupId').val('')
                  //modal.find('.modal-body input').val(groupname)

                  var datastring = "groupid="+groupid;
                    //alert(datastring);
                    $.ajax({
                        url: siteUrl + '/settings/mycontactgroup/showgrp/'+groupid,
                        async: true,
                        type: "GET",
                        // data: datastring,
                        dataType: "html",
                        // contentType: false,
                        // cache: false,
                        // processData: false,
                        success: function (data)
                        {

                            modal.find('#addContactsPopGroupId').val(groupid)
                            modal.find('.modal-body').html(data)

                            $('#addContactsPop').attr("data-popgroupid",groupid)
                            $('#addContactsPop').attr("data-popgroupname",groupname)
                        }

                    }); 
                  //modal.find('.modal-body').html("groupname")
                });



                //Delete the contact data
                function mycontact_data_delete(id)
                {

                    alertify.confirm("Do you want to continue to delete this contact?", function (asc) {
                        if (asc) {
                            //ajax call for delete    
                            var dataString = 'id=' + id;

                            $.ajax({
                                url: siteUrl + '/settings/mycontact/'+id,
                                async: true,
                                type: "DELETE",
                                // data: dataString,
                                data: {"id": id , _method: 'delete'},
                                dataType: "html",
                                // contentType: false,
                                // cache: false,
                                // processData: false,
                                success: function (data)
                                {
                                    if(data == "success"){
                                        // alert("Contact Deleted");
                                        loadMyContactDatatable();
                                        loadMyContactGroupDatatable();
                                    }
                                    //location.reload();
                                    
                                }
                            });   
                            alertify.success("Contact is deleted.");

                        } else {
                            alertify.error("You've clicked cancel");
                        }
                    },"Default Value");

 

                }

                //Delete the group data
                function mycontactgroup_data_delete(id)
                {

                    alertify.confirm("Do you want to continue to delete this group?", function (asc) {
                        if (asc) {
                            //ajax call for delete    
                            var dataString = 'id=' + id;

                            $.ajax({
                                url: siteUrl + '/settings/mycontactgroup/'+id,
                                async: true,
                                type: "DELETE",
                                // data: dataString,
                                data: {"id": id , _method: 'delete'},
                                dataType: "html",
                                // contentType: false,
                                // cache: false,
                                // processData: false,
                                success: function (data)
                                {
                                    if(data == "success"){
                                        // alert("Group Deleted");
                                        loadMyContactDatatable();
                                        loadMyContactGroupDatatable();
                                    }
                                    //location.reload();
                                    
                                }
                            });   
                            alertify.success("Group is deleted.");

                        } else {
                            alertify.error("You've clicked cancel");
                        }
                    },"Default Value");                    

                }
        </script>

    @endsection    
@endsection