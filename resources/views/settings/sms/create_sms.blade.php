@extends('layouts.default')

@section('content')
<link href="{{ URL::asset('assets/select2/select2.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ URL:: asset('assets/select2/select2.js')}}"></script>
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group pull-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item active">Send New SMS</li>
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

                                <h4 class="mt-0 header-title">Send New SMS</h4>

                                @if($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ $message }}</strong>
                                </div>
                                @endif
                                <!-- -->
                                <form method="post" enctype="multipart/form-data" action="{{ route('sms.store') }}" id='sendSMSForm' name='sendSMSForm'>
                                    @csrf
                                    <div class="form-group">
                                        <label>Select Groups:</label>
                                        

                                        <div class="table-responsive">    
                                            
                                                @if($selectMyContactGroupDetail->count()>0)  
                                                    <table id="contact-group-datatable" class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">#</th>
                                                                <th>Group Name</th>
                                                                <th>No of Contacts</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody> 
                                                    @foreach($selectMyContactGroupDetail as $selectMyContactGroupDetailVal)              
                                                        <tr>
                                                            <td><input type="checkbox" name="grp_ids[]" id="grp_ids" value="{{$selectMyContactGroupDetailVal->id}}"></td>
                                                            <td>{{$selectMyContactGroupDetailVal->group_name}}</td>
                                                            <td>{{$selectMyContactGroupDetailVal->grpcontactcount}}</td>

                                                        </tr>

                                                    @endforeach
                                                        </tbody>
                                                    </table>

                                                @else

                                                <p style="display: none;">
                                                    <input type="checkbox" name="grp_ids[]" id="grp_ids" value="">
                                                </p>
                                                    <div class="alert alert-danger alert-block">
                                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                                        <h5>Please create the group first.<a href="{{asset('/settings/mycontact')}}">Click here</a></h5>
                                                    </div>
                                                    
                                                @endif
                                                
                                        </div>

                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <label>Sender ID:</label>
                                        
                                        <select class="form-control" name="sms_sender_id" id="sms_sender_id" >
                                            <!-- <option value="">--Select--</option> -->
                                            <option value="DALLAS">DALLAS</option>
                                            
                                        </select>
                                        
                                    </div>
                                      
                                    <div class="form-group">
                                        <label>SMS Text</label>
                                        <!-- <div> -->
                                            <!-- <div class="camp_message" name="camp_message" id="camp_message" ></div> -->

                                            <textarea name="message" id="message" class="form-control" rows="5"></textarea>
                                        <!-- </div> -->
                                    </div>
 
                                    <div class="form-group">
                                        <div>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                Send SMS
                                            </button>
                                            <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                Discard
                                            </button>
                                        </div>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div> <!-- end col -->




            </div> <!-- end row -->

@section('js_script')            
        <link href="{{ URL::asset('css/adminlte.css') }}" rel="stylesheet" type="text/css" />
        <!--Wysiwig js-->
        <script src="{{ URL:: asset('assets/theme/plugins/tinymce/tinymce.min.js')}}"></script>
        
        <!-- Summernote css -->
        <link href="{{ URL::asset('assets/theme/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet" type="text/css" />

        <!--Summernote js-->
        <script src="{{ URL:: asset('assets/theme/plugins/summernote/summernote-bs4.min.js')}}"></script>

        <script>
            $(document).ready(function() {
                chkValidateStatus = "";
                chkValidateStatus = $("#sendSMSForm").validate({
                    //ignore:[],// false,
                    
                    ignore: false,
                    errorClass: "error",
                    rules: {
                        "grp_ids[]": { 
                            required: true, 
                            minlength: 1 
                        } ,
                        sms_sender_id: {
                            required: true
                        },
                        message: {
                            required: true
                        }
                    },
                    messages: {
                        "grp_ids[]": "Please select at least one group."
                        ,
                        sms_sender_id: {
                            required: "Please select Sender ID:"
                        },
                        message: {
                            required: "Please enter sms text"
                        } 
                    }
                });
            });

        </script>
  
@endsection
@endsection



