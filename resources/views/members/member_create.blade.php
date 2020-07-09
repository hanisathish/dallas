@extends('layouts.default')

@section('content')
        <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <div class="btn-group pull-right">
                                <ol class="breadcrumb hide-phone p-0 m-0">
                                    <li class="breadcrumb-item active">Member Create</li>
                                </ol>
                            </div>
                            <!--<h4 class="page-title">Form Validation</h4>-->
                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->
@if ($errors->any())
<div class="error">
    <ul style="list-style: none;padding: 0">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
</div>
@endif

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<?php
    $formUrl = "/people/member/management";
    $member_id = isset(request()->route()->parameters['personal_id'])? request()->route()->parameters['personal_id'] : null;
    if($member_id){
        $formUrl = $formUrl ."/". $member_id;
    }
?>
                <!-- <p><code>.row</code>:</p> -->
{!! Form::open(array('id'=>'userMasterCreateForm','name'=>'userMasterCreateForm','method' => 'post', 'url' => $formUrl, 'class' => '','files' => true)) !!}
    <!-- flex:100%;max-width:100%; -->
  <div class="row" style="flex:100%;background-color: #fff;padding:1.25em">
    <div class="col-sm-2 col-lg-2 col-md-2 divcols" >
        <?php
        $profile_pic_image = url('/assets/uploads/organizations/avatar.png');
        if(isset($user)){
            if ($user->profile_pic != null) {
                $profile_pic_image_json = json_decode(unserialize($user->profile_pic));
                $profile_pic_image = $profile_pic_image_json->download_path . $profile_pic_image_json->uploaded_file_name;
            }    
        }
        
        ?>
        <img class="d-flex mr-2 rounded-circle img-thumbnail thumb-lg" src="{{$profile_pic_image}}" alt="Generic placeholder image">
    </div>
    <div class="col-sm-2 col-lg-2 col-md-2 divcols" >
        <label>Prefix</label>
        <select class="form-control" name="name_prefix" id="name_prefix" >
            <option value="">--Select--</option>
            @foreach($name_prefix as $value)
            <option {{ (isset($user) && $user->name_prefix==$value->mldId)?'selected':''}} value="{{$value->mldId}}">{{$value->mldValue}}</option>
            @endforeach            
        </select>
    </div>
    <div class="col-sm-2 col-lg-2 col-md-2 divcols" >
        <label>First</label>
      <input type="text" required class="form-control" name="first_name" id="first_name" placeholder="First name" value="{{ old('first_name', isset($user) ? $user->first_name : '') }}">
    </div>
    <div class="col-sm-2 col-lg-2 col-md-2 divcols" >
        <label>Middle</label>
      <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Middle name" value="{{ old('middle_name', isset($user) ? $user->middle_name : '') }}">
    </div>
    <div class="col-sm-2 col-lg-2 col-md-2 divcols" >
        <label>Last</label>
      <input type="text"  class="form-control" name="last_name" id="last_name" placeholder="Last name" value="{{ old('last_name', isset($user) ? $user->last_name : '') }}">
    </div>

    <div class="col-sm-2 col-lg-2 col-md-2 divcols" >
        <label>Suffix</label>
        <select class="form-control" name="name_suffix" id="name_suffix" >
            <option value="">--Select--</option>
            @foreach($name_suffix as $value)
            <option {{ (isset($user) && $user->name_suffix==$value->mldId)?'selected':''}} value="{{$value->mldId}}">{{$value->mldValue}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-sm-3 col-lg-3 col-md-3 divcols" style="display: none;">
        <label>Given Name</label>
      <input type="text" class="form-control" name="given_name" id="given_name" placeholder="Given name" value="{{ old('given_name', isset($user) ? $user->given_name : '') }}">
    </div>

    <div class="col-sm-3 col-lg-3 col-md-3 divcols" >
        <label>Nickname</label>
      <input type="text" class="form-control" name="nick_name" id="nick_name" placeholder="Nickname" value="{{ old('nick_name', isset($user) ? $user->nick_name : '') }}">
    </div>

    <div class="col-sm-3 col-lg-3 col-md-3 divcols" >
        <label>Email</label>
        <input required="" type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email', isset($user) ? $user->email : '') }}">
    </div>

    <div class="col-sm-3 col-lg-3 col-md-3 divcols" >
        <label>Phone</label>
      <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Phone" value="{{ old('mobile_no', isset($user) ? $user->mobile_no : '') }}">
    </div>

    <div class="col-sm-3 col-lg-3 col-md-3 divcols" >
        <label>Street Address</label>
      <input type="text" class="form-control" name="street_address" id="street_address" placeholder="Street Address" value="{{ old('street_address', isset($user) ? $user->street_address : '') }}">
    </div>
    <div class="col-sm-3 col-lg-3 col-md-3 divcols" >
        <label>Apt/unit/box</label>
      <input type="text" class="form-control" name="apt_address" id="apt_address" placeholder="Apt/unit/box" value="{{ old('apt_address', isset($user) ? $user->apt_address : '') }}">
    </div>
    <div class="col-sm-3 col-lg-3 col-md-3 divcols" >
        <label>City</label>
      <input type="text" class="form-control" name="city_address" id="city_address" placeholder="City" value="{{ old('city_address', isset($user) ? $user->city_address : '') }}">
    </div>
    <div class="col-sm-3 col-lg-3 col-md-3 divcols" >
        <label>State</label>
      <input type="text" class="form-control" name="state_address" id="state_address" placeholder="State" value="{{ old('state_address', isset($user) ? $user->state_address : '') }}">
    </div>
    <div class="col-sm-3 col-lg-3 col-md-3 divcols" >
        <label>Zip</label>
      <input type="text" class="form-control" name="zip_address" id="zip_address" placeholder="Zip" value="{{ old('zip_address', isset($user) ? $user->zip_address : '') }}">
    </div>

    <div class="col-sm-3 col-lg-3 col-md-3 divcols" >
        <label>&nbsp;</label>
        <select class="form-control" name="life_stage" id="life_stage">
            <option value="Adult">Adult</option>
            <option value="Child">Child</option>
            </select>
        
    </div>
    <div class="col-sm-3 col-lg-3 col-md-3 divcols" >
        <label>Gender</label>
        <select class="form-control" name="gender" id="gender">
            <option value="">--Select--</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        
    </div>

    <div class="col-sm-3 col-lg-3 col-md-3 divcols" >
        <label>Birthdate</label>
        <div class="input-group">
            <input type="text" class="form-control datepicker-autoclose" name="dob" id="dob" placeholder="mm/dd/yyyy" value="{{ old('dob', isset($user) ? $user->dob : '') }}">
            <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
        </div><!-- input-group -->
    </div>
    <div class="col-sm-3 col-lg-3 col-md-3 divcols" >
        <label>Marital Status</label>
        <select class="form-control" name="marital_status" id="marital_status">
            <option value="">--Select--</option>
            @foreach($marital_status as $value)
            <option {{ (isset($user) && $user->marital_status==$value->mldId)?'selected':''}} value="{{$value->mldId}}">{{$value->mldValue}}</option>
            @endforeach
        </select>
        
    </div>

    <div class="col-sm-3 col-lg-3 col-md-3 divcols" >
        <label>Anniversary</label>
        <div class="input-group">
            <input type="text" class="form-control datepicker-autoclose" name="doa" id="doa" placeholder="mm/dd/yyyy" value="{{ old('doa', isset($user) ? $user->doa : '') }}">
            <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
        </div><!-- input-group -->
    </div> 

    <div class="col-sm-3 col-lg-3 col-md-3 divcols" >
        <label>School</label>
        <select class="form-control" name="school_name" id="school_name">
            @foreach($school_name as $value)
            <option {{ (isset($user) && $user->school_name==$value->mldId)?'selected':''}} value="{{$value->mldId}}">{{$value->mldValue}}</option>
            @endforeach
        </select>
        
    </div>

    <div class="col-sm-3 col-lg-3 col-md-3 divcols" >
        <label>Grade</label>
        <select class="form-control" name="grade_id" id="grade_id">
            @foreach($grade_id as $value)
            <option {{ (isset($user) && $user->grade_id==$value->mldId)?'selected':''}} value="{{$value->mldId}}">{{$value->mldValue}}</option>
            @endforeach
        </select>
        
    </div>

    <div class="col-sm-3 col-lg-3 col-md-3 divcols" >
        <label>Add a note</label>
        <textarea class="form-control" name="medical_note" id="medical_note">{{ old('medical_note', isset($user) ? $user->medical_note : '') }}</textarea> 
    </div>
    <div class="col-sm-3 col-lg-3 col-md-3 divcols" >
        <label>Social profile</label>
        <input type="text" class="form-control" name="social_profile" id="social_profile" placeholder="Social profile" value="{{ old('social_profile', isset($user) ? $user->social_profile : '') }}"> 
    </div>
    <div class="col-sm-3 col-lg-3 col-md-3 divcols" >
        <label>Role</label>
        <select class="form-control" name="roles" id="roles">
            @foreach($rolesData as $value)
            <option {{ (isset($user) && $user->roles()->pluck('role_id')[0]==$value->id)?'selected':''}} value="{{$value->id}}">{{$value->name}}</option>
            @endforeach
        </select>
        
    </div>
    
    <div class="col-sm-12 col-lg-12 col-md-12 divcols" >
        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-primary waves-effect waves-light">
                    {{isset($user)? 'Update' : "Create"}}
                </button>
                <a href="{{ URL::asset('people/member_directory')}}" type="reset" class="btn btn-secondary waves-effect m-l-5">
                    Close
                </a>
            </div>
        </div>  
    </div>  
  </div>
{{ Form::close() }}
 

<style type="text/css">
    .divcols {
        padding: 0.25em;
    }
</style>        

 <!-- Plugins Init js -->
        
        
@endsection                

