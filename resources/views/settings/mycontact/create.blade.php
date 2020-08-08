@extends('layouts.default')


@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item active">Add/Edit Contacts</li>
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

                <h4 class="mt-0 header-title">Add/Edit Contacts</h4>
                
                @if(!isset($mycontact->id))
                    <form action="{{ route('mycontact.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal" id='addEditContactForm' name='addEditContactForm' >
                @else        
                <form action="{{ route('mycontact.update',$mycontact->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal" id='addEditContactForm' name='addEditContactForm'>
                    @method('PUT')
                @endif    
                        @csrf                 
                        
                                        
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="c_email">Email</label>
                        <div class="col-md-3">
                            <input type="email" id="c_email" name="c_email" value="{{ old('c_email', isset($mycontact) ? $mycontact->c_email : '') }}" class="form-control" placeholder="Email">
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="c_f_name">First Name</label>
                        <div class="col-md-3">
                            <input type="text" id="c_f_name" name="c_f_name" class="form-control" placeholder="First Name" value="{{ old('c_f_name', isset($mycontact) ? $mycontact->c_f_name : '') }}">
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="c_l_name">Last Name</label>
                        <div class="col-md-3">
                            <input type="text" id="c_l_name" name="c_l_name" class="form-control" placeholder="First Name" value="{{ old('c_l_name', isset($mycontact) ? $mycontact->c_l_name : '') }}">
                            
                        </div>
                    </div>  
                     
                    <div class="form-group">
                        <label class="col-md-2 control-label">Groups</label>
                        <div class="col-md-10">
                            <div class="col-sm-12">

                                @if($crudMyContactGroup->count() > 0)
                                
                                    @foreach($crudMyContactGroup as $crudMyContactGroupValue)
                                        <div class="col-sm-3">
                                            <label class="checkbox-inline" for="">

                                                <input type="checkbox" id="group_id" name="group_id[]" value="{{$crudMyContactGroupValue->id}}"
                                                {{ (isset($selectFromContactGroupMap) ? ( in_array($crudMyContactGroupValue->id, array_column($selectFromContactGroupMap->toArray(),'contact_group_id')) ? "checked" : "") : "") }}  /> {{$crudMyContactGroupValue->group_name}}
                                            </label>
                                        </div>
                                    @endforeach    
                                
                                @else
                                <div class="col-sm-3">
                                    <label class="checkbox-inline" for="">
                                        No Groups
                                    </label>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-5 col-md-offset-2">
                            <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i> Submit</button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->


@section('js_script')


     <!-- Javascript code only for this page -->


    <script>
        $(document).ready(function() {
            chkValidateStatus = "";
            chkValidateStatus = $("#addEditContactForm").validate({
                //ignore:[],// false,
                ignore: false,
                errorClass: "error",
                rules: {
                    c_email: {
                        required: true,
                        email:true
                    },
                    c_f_name: {
                        required: true
                    },
                    c_l_name: {
                        required: false
                    }
                },
                messages: {
                    c_email: {
                        required: "Please enter email"
                    },
                    c_f_name: {
                        required: "Please enter first name"
                    },
                    c_l_name: {
                        required: "Please enter last name"
                    }
                }
            });
        });

    </script>

    @endsection
@endsection