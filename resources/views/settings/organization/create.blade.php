@extends('layouts.default')

@section('content')
<!-- <div style="width:100vw"> -->
    @include('settings.organization.header')

    <?php
        $formUrl = "/settings/organization/store";
		
        $org_id = isset(request()->route()->parameters['org_id'])? request()->route()->parameters['org_id'] : null;
	
		if($org_id){
            $formUrl = "/settings/organization/save/".$org_id;
        }
		
    ?>
    <div class="row">
        <div class="col-sm-0 col-md-1 col-lg-2"></div>
        <div class="col-sm-12 col-md-10 col-lg-8 card">
            <!-- <div class="card m-b-30"> -->
            <div class="card-body pl-0 pr-0">
                <h5 class="mt-0 pl-3"> {{($org_id)? 'Edit' : "Create" }} Organization</h5>
                <hr />
                <div class="row p0 m-0">
                    {!! Form::open(array('id'=>'organizationForm','name'=>'organizationForm','method' => 'post', 'url' => $formUrl, 'class' => 'organizationForm col-sm-12 card p-2','files' => true)) !!}
		    					 
                        <input type="text" id="orgId" name="orgId" value="{{isset($org_id)? $org_id : ''}}" class="d-none">
                        <input type="text" id="userId" name="userId" value="{{isset($user_Id)? $user_Id : ''}}" class="d-none">

 
                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30">
                                    <div class="card-body">																
										
                                     
										<div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Organization/Church Name</label>
                                            <div class="col-sm-10">
                                                <input id="orgName" type="text" class="form-control @error('orgName') is-invalid @enderror" name="orgName" value="{{ old('orgName', isset($getOrganizationUserValues)? $getOrganizationUserValues->orgName : '') }}" placeholder="Organization/Church Name" autofocus required >
                                            </div>
                                        </div>

                                        
										<div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Organization/Church Sub Domain Name</label>
                                            <div class="col-sm-10">
                                                <input id="orgDomain" type="text" class="form-control @error('orgDomain') is-invalid @enderror" name="orgDomain" value="{{ old('orgDomain', isset($getOrganizationUserValues) ? $getOrganizationUserValues->orgDomain : '') }}" placeholder="Organization/Church Sub Domain Name"    autofocus required >
                                            </div>
                                        </div>
										
										
										<div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">First Name</label>
                                            <div class="col-sm-10">
                                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', isset($getOrganizationUserValues) ? $getOrganizationUserValues->first_name : '') }}"    autofocus required placeholder="Name">
                                            </div>
                                        </div>
										
										
										
										<div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', isset($getOrganizationUserValues) ? $getOrganizationUserValues->email : '') }}"    autofocus required placeholder="Email">
                                            </div>
                                        </div>
										
										<?php
										if($org_id == ""){
										?>
											<div class="form-group row">
												<label for="example-text-input" class="col-sm-2 col-form-label">Password</label>
												<div class="col-sm-10">
													<input class="form-control" name="password" id="password" type="password" value="" placeholder="Password" required>
												</div>
											</div>

																			
											<div class="form-group row">
												<label for="example-text-input" class="col-sm-2 col-form-label">Confirm Password</label>
												<div class="col-sm-10">
													<input class="form-control" name="confirm_password" id="confirm_password" type="password" value="" placeholder="Confirm Password" required>
												</div>
											</div>
					
											<div class="form-group row">
												<label for="example-date-input" class="col-sm-2 col-form-label">Timezone</label>
												<div class="col-sm-10">
													{!! $dateTimezone !!}
												</div>
											</div>
										<?php
										}
										?>
										<div class="form-group">
											<div>
												<button type="submit" class="btn btn-primary waves-effect waves-light">
													Submit
												</button>
												<a href="{{ URL::asset('settings/organization')}}" type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</a>
											</div>
										 </div>
										
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </form>
                </div>
            </div>
            <!-- </div> -->
        </div>
    </div>
    
<!-- </div> -->
@endsection

@section('js_script')
<link href="{{ URL::asset('css/custom_page.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ URL:: asset('js/custom/org_register.js')}}"></script>

@endsection