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

                                <h4 class="mt-0 header-title">Notification:</h4>
                                

                                <div class="form-group row">
                                    <label class="col-sm-9 col-form-label">Check in Notification to Parents:</label>
                                    <div class="col-sm-3">
                                        <select class="form-control">
                                            <option>Template1</option>
                                            <option>Large select</option>
                                            <option>Small select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-9 col-form-label">Check in Notification to Guests</label>
                                    <div class="col-sm-3">
                                        <select class="form-control">
                                            <option>Template1</option>
                                            <option>Large select</option>
                                            <option>Small select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-9 col-form-label">Check in Notification to Parents when Guest Checkin:</label>
                                    <div class="col-sm-3">
                                        <select class="form-control">
                                            <option>Template1</option>
                                            <option>Large select</option>
                                            <option>Small select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-9 col-form-label">Check out Notification to Parents:</label>
                                    <div class="col-sm-3">
                                        <select class="form-control">
                                            <option>Template1</option>
                                            <option>Large select</option>
                                            <option>Small select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-9 col-form-label">Check out Notification to Guest:</label>
                                    <div class="col-sm-3">
                                        <select class="form-control">
                                            <option>Template1</option>
                                            <option>Large select</option>
                                            <option>Small select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-9 col-form-label">Check out Notification to Parent when Guest Checkin:</label>
                                    <div class="col-sm-3">
                                        <select class="form-control">
                                            <option>Template1</option>
                                            <option>Large select</option>
                                            <option>Small select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-9 col-form-label">Yet to Checkout for Closing Events:</label>
                                    <div class="col-sm-3">
                                        <select class="form-control">
                                            <option>Template1</option>
                                            <option>Large select</option>
                                            <option>Small select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-9 col-form-label">Report to Pastor, Admin on Every day event.</label>
                                    <div class="col-sm-3">
                                        <select class="form-control">
                                            <option>Template1</option>
                                            <option>Large select</option>
                                            <option>Small select</option>
                                        </select>
                                    </div>
                                </div>

 
                            </div>
                        </div>
                    </div> <!-- end col -->    
                
                
                
                
            </div> <!-- end row -->
        
        
@endsection


        
