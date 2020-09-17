@extends('layouts.default')

@section('content')
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group pull-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item active">SMS Management</li>
                            </ol>
                        </div>
                        <!--<h4 class="page-title">Roles Management</h4>-->
                        <!--<a href="{{URL::asset('role_create')}}" type="button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-plus"></i>Add Role</a>-->
                    </div>
                </div>
            </div>
            <!-- end page title end breadcrumb -->

            <div class="row">
                    @include('settings.sms.sms_sidebar')
            <div class="col-lg-9">
                        <div class="card m-b-30">
                            <div class="card-body">

                                

  
                                <table class="table table-hover table-striped smsDatatable" id="smsDatatable">
                                  <thead>
                                    <th>Receiver mobile</th>
                                    <th>SMS</th>
                                    <th>Sent Date</th>
                                    <th>Status</th>
                                  </thead>
                                  <tbody>
                                  <!-- <tr>
                                    <td><input type="checkbox"></td>
                                    <td><a class="btn btn-default btn-sm"><i class="fa fa-trash"></i></a></td>
                                    <td class="mailbox-star"><a href="#"><i class="fa fa-star text-warning"></i></a></td>
                                    <td class="mailbox-name"><a href="">Alexander Pierce</a></td>
                                    <td class="mailbox-subject"><b>Issue</b> - Trying to find a solution to this problem...
                                    </td>
                                    <td class="mailbox-attachment"></td>
                                    <td class="mailbox-date">5 mins ago</td>
                                  </tr> -->
                                    
                                  </tbody>
                                </table>


                            </div>
                        </div>
                    </div> <!-- end col -->




            </div> <!-- end row -->
<link href="{{ URL::asset('css/adminlte.css') }}" rel="stylesheet" type="text/css" />
            <script>

             $(document).ready(function() {

                loadDatatable();
               


              // $("#eventDateSearch").
            });

                function loadDatatable(){
                    
                    smsDatatable = $('#smsDatatable').DataTable({
                    "serverSide": true,
                    "destroy": true,
                    "autoWidth": false,
                    "searching": true,
                    "aaSorting": [
                        [0, "desc"]
                    ],
                    "columnDefs": [],
                    pageLength: 15,
                    lengthMenu: [[15, 20, 50, -1], [15, 20, 50, "All"]],
                    "ajax": {
                        type: "POST",
                        data: {},
                        url: siteUrl + '/settings/sms/list',
                    },
                    "initComplete": function(settings, json) {
                        // $("#eventsTable_filter").append('<button class="btn small btn-primary" id="eventDateSearch"  >Event Date</button>');

                    }
                });

                /* Add placeholder attribute to the search form */
                $('.dataTables_filter input').attr('placeholder', 'Search');

                     
                }
  


                    </script>

@endsection



