@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="text-white card-primary" >
                <div class="card-body">
                    <input type="hidden" name="form_id_hidden" id="form_id_hidden" value="{{$form_id}}">
                    <h6>Create New Form<a href="{{URL::asset('/settings/forms')}}" class="btn btn-secondary btn-sm pull-right">Forms List</a></h6>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form_builder" style="margin-top: 25px">
                <div class="row">
                    <div class="col-sm-2">
                        <nav class="nav-sidebar">
                            <h6 class="text-secondary" style="margin-bottom:0px;">Profile Fields</h6><hr>
                            <ul class="nav profile_fields"></ul>
                            <h6 class="text-secondary" style="margin-bottom:0px;">Basic Form Fields</h6><hr>
                            <ul class="nav basic_fields"></ul>
                        </nav>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Form Title</span>
                            </div>
                            <input type="text" id="formTitle" class="form-control" placeholder="Enter Form Title">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Description</span>
                            </div>
                            <input type="text" id="formDes" class="form-control" placeholder="Enter Form Description">
                        </div>
                        <small><strong>First Name, Middle Name, Last Name and Email Address</strong> are always collected by every form.</small>
                        <div class="row bal_builder">
                            <div class="form_builder_area"></div>
                            <!-- <div class="row"> -->
                                <div class="col-sm-12 card text-white bg-secondary mb-3 empty-block" style="min-height:100px; margin-top:20px;">
                                    <div class="card-body">
                                        <h5><i class="fa fa-plus"></i> Drag a field here to get started!</h5>
                                    </div>
                                </div>
                            <!-- </div> -->
                        </div>
                        
                    </div>
                    <div class="col-md-5">
                        <div class="col-md-12 bg-light p-2">
                            <form class="form-horizontal">
                                <div id="form-preview"></div>
                        </div>
                    </div>
                </div>
            </div>
    <div class="row">
        <!-- Form Fields List and Form elements -->
        <div class="col-sm-8">
            
        </div>
    </div>
    <script src="{{ URL:: asset('assets/theme/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{ URL:: asset('js/fetch_api_call.js')}}"></script>
    <script src="{{ URL:: asset('js/forms/form-build.js')}}"></script>
@endsection