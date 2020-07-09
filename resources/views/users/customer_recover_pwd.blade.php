@extends('layoutslogin.default')

@section('content')
			
    <div class="row">
        <div class="col-sm-0 col-md-1 col-lg-2"></div>
        <div class="col-sm-12 col-md-10 col-lg-8 card">
            <div class="card-body pl-0 pr-0">
			
			    <h3 class="text-center mt-0 m-b-15">
                        @if ($crudOrganizationData->count() > 0)
                            @if($crudOrganizationData[0]->orgLogo == "")
                                @php ($orgLogoName = 'assets/uploads/organizations/bible-cross-logo.png')
                            @else
                                @php ($orgLogoName = 'assets/uploads/organizations/'.$crudOrganizationData[0]->orgId.'/org_logo/'.$crudOrganizationData[0]->orgLogo)
                            @endif

                            <a href="" class="logo logo-admin"><img src="{{ URL::asset($orgLogoName)}}" alt="" height="55" class="logo-large"></a>
                        @else
                            <a href="" class="logo logo-admin"><img src="{{ URL::asset('assets/theme/images/bible-cross-logo.png')}}" alt="" height="55" class="logo-large"></a>
                        @endif                        
                </h3>
					
                <h5 class="mt-0 pl-3"><center> Change Password </center> </h5>
                <hr />
                <div class="row p0 m-0">
         {!! Form::open(array('id'=>'createCustomerForm','name'=>'createCustomerForm','method' => 'post', 'url' => url('customerpwdstore'), 'class' => 'createCustomerForm col-sm-12 card p-2','files' => true)) !!}
                    					    
                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30">
                                    <div class="card-body">									
									  
									  <input type="hidden" name="id" id="id" value="{{ old('id', !empty($getUserLists) ? $getUserLists->id : '') }}" />
								
									   <div class="form-group">
										<label class="col-sm-12">Password:</label>
										<div class="col-lg-9">
											<input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-12">Confirm Password:</label>
										<div class="col-lg-9">
											<input type="password" class="form-control" placeholder="Confirm Password" name="repeat_password" id="repeat_password" required>
										</div>
									</div>                              

									<div class="text-right">
										<button type="submit" name="submitCusPwd" class="btn btn-primary">Submit form <i class="icon-arrow-right14 position-right"></i></button>
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
</div>

<script type='text/javascript'>

</script>

@endsection