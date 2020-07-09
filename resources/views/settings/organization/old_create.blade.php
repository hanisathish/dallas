<form method="post" action="{{ route('organization.store') }}" name="create_location_form" id="create_location_form" enctype="multipart/form-data">
 <div id="create_location_form_status"></div>
    <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30" style="margin-bottom: 0">
                            <div class="card-body">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}">


                                 <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Organization Name</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" required="" type="text" value="{{ isset($organization)?$organization->orgName:'' }}" id="orgName" name="orgName">
                                    </div>
                                 </div>
								 
								 <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Organization Domain</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" required="" type="text" value="{{ isset($organization)?$organization->orgDomain:'' }}" id="orgDomain" name="orgDomain">
                                    </div>
                                 </div>
								 
								
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
				
 <input type="hidden" name="orgId" value="{{ isset($organization)?$organization->orgId:'' }}" />
 <input type="submit" id="formSubmitBtn" style="display: none;" />
</form>
