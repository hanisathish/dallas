@extends('layouts.default')

@section('content')


<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item active">Church Settings</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<form method="post" action="{{ route('church.store') }}" name="update_church_form" id="update_church_form" enctype="multipart/form-data">
              <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body"> 
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">

                            <h4 class="mt-0 header-title">Church Information </h4>
                            
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Organization Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="{{ isset($list_church_data)?$list_church_data->orgName:'' }}" id="orgName" name="orgName"> 
                                </div>
                            </div>

                            <div class="form-group row">
                                    <label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="email" value="{{ isset($list_church_data)?$list_church_data->orgEmail:'' }}" id="orgEmail" name="orgEmail">
                                    </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-url-input" class="col-sm-2 col-form-label">Website</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="url" value="{{ isset($list_church_data)?$list_church_data->orgWebsite:'' }}" id="orgWebsite" name="orgWebsite">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-tel-input" class="col-sm-2 col-form-label">Phone Number</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="tel" value="{{ isset($list_church_data)?$list_church_data->orgPhone:'' }}" id="orgPhone" name="orgPhone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-search-input" class="col-sm-2 col-form-label">Organization Address</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="search" value="{{ isset($list_church_data)?$list_church_data->orgAddress:'' }}" id="orgAddress" name="orgAddress">
                                </div>
                            </div>                            
                            <div class="form-group row">
                                <label for="example-search-input" class="col-sm-2 col-form-label">City</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="search" value="{{ isset($list_church_data)?$list_church_data->orgCity:'' }}" id="orgCity" name="orgCity">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-search-input" class="col-sm-2 col-form-label">State</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="search" value="{{ isset($list_church_data)?$list_church_data->orgState:'' }}" id="orgState" name="orgState">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-date-input" class="col-sm-2 col-form-label">Country</label>
                                <div class="col-sm-10">
                                <select class="form-control" name="orgTimeCountry" id="orgTimeCountry">
                                    <option {{ (isset($list_church_data) && $list_church_data->orgTimeCountry==1)?'selected':''}}  value="1">India</option>
                                    <option {{ (isset($list_church_data) && $list_church_data->orgTimeCountry==2)?'selected':''}}  value="2">USA</option>                                 
                                </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-search-input" class="col-sm-2 col-form-label">Pincode</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="search" value="{{ isset($list_church_data)?$list_church_data->orgPincode:'' }}" id="orgPincode" name="orgPincode">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-date-input" class="col-sm-2 col-form-label">Logo</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" value="" id="orgLogo" name="orgLogo" >
                                </div>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

    <input type="hidden" name="orgId" value="{{ isset($orgId)?$orgId:'' }}" />
    <div class="col-sm-12 col-lg-12 col-md-12 divcols" >
        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-primary waves-effect waves-light">
                    Save Changes
                </button>
            </div>
        </div>  
    </div>  
  </div>
 </form>
    
    <!-- end wrapper -->

@endsection  
