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

                                <h4 class="mt-0 header-title">Adult Checkin</h4>
                                

                                <!-- -->
                                <div class="button-items">
                                    <button type="button" class="btn btn-primary waves-effect waves-light">Create household</button>

                                    <button type="button" class="btn btn-secondary waves-effect">Add checkin</button>

                                    <button type="button" class="btn btn-success waves-effect waves-light">Checkout</button>
 
 
                                </div>
                                <br>
                                <!-- -->
                                <table id="datatable" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th></th><th></th>
                                    </tr>
                                    </thead>


                                    <tbody>
                                    <tr>
                                        <td><img src="{{ URL::asset('assets/uploads/profile/1images.jpg')}}" alt="" height="30" class="logo-large"></td>
                                        <td>Regular @8.00 A.M</td>
                                        <td>In At 3/10 @10:00AM</td>
                                        
                                    </tr>
                                         
                                    
                                    
                                    </tbody>
                                </table>

 
                            </div>
                        </div>
                    </div> <!-- end col -->    
                
                
                
                
            </div> <!-- end row -->
        
        
@endsection


        
