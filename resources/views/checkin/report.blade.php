@extends('layouts.default')

@section('content')
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group pull-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item active">Checkin</li>
                            </ol>
                        </div>
                        <!--<h4 class="page-title">Roles Management</h4>-->
                        <!--<a href="{{URL::asset('role_create')}}" type="button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-plus"></i>Add Role</a>-->
                    </div>
                </div>
            </div>
            <!-- end page title end breadcrumb -->

            <div class="row">
                    <div class="col-lg-3">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="button-items">
                                    <a href="{{URL::asset('checkin/adult')}}" class="btn btn-primary btn-lg btn-block">Adult Checkin</a>
                                    <a href="{{URL::asset('checkin/child')}}" class="btn btn-primary btn-lg btn-block">Child Checkin</a>
                                    <a href="{{URL::asset('checkin/notification')}}" class="btn btn-primary btn-lg btn-block">Notification</a>
                                    <a href="{{URL::asset('checkin/report')}}" class="btn btn-primary btn-sm btn-block">Report</a>
                                </div>
                            </div>
                        </div>
                    </div>
            <div class="col-lg-9">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <h4 class="mt-0 header-title">Reports</h4>
                                

                                <!-- -->
                                <div class="button-items">
                                    <button type="button" class="btn btn-primary waves-effect waves-light">Add Child</button>

                                    <button type="button" class="btn btn-secondary waves-effect">New Report</button>
 
 
                                </div>
                                <br>


                                <h3 class="mt-0 header-title">CUSTOM REPORTS</h3>

                                <!-- -->
                                <table id=" " class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th></th><th></th>
                                    </tr>
                                    </thead>


                                    <tbody>
                                    <tr>
                                        <td>xxxx</td>
                                        <td>Last Update by : xxx</td>
                                        <td>on oct 03, 2017</td>
                                        
                                    </tr>
                                         
                                    
                                    
                                    </tbody>
                                </table>

                                <div class="button-items">
                                    <button type="button" class="btn btn-primary waves-effect waves-light">Preview</button>

                                    <button type="button" class="btn btn-secondary waves-effect">PDF</button>
                                    <button type="button" class="btn btn-secondary waves-effect">CSV</button>
 
 
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->    
                
                
                
                
            </div> <!-- end row -->
        
        
@endsection


        
