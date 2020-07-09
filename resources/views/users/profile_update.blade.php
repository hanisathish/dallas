<form method="post" action="{{ route('profile.store') }}" name="profile_update_form" id="profile_update_form" enctype="multipart/form-data">
 <div id="profile_update_form_status"></div>
    <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}">
								
                                 <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-2 col-form-label">Full Name</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" value="{{ $get_profile_info->full_name }}" id="full_name" name="full_name">
                                    </div>
                                 </div>

                                 <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-2 col-form-label">Mobile</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" value="{{ $get_profile_info->mobile_no }}" id="mobile_no" name="mobile_no">
                                    </div>
                                </div>

                                 <!--<div class="form-group row">
                                    <label for="example-date-input" class="col-sm-2 col-form-label">Profile Image</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="file" value="" id="profile_pic" name="profile_pic">
                                    </div>
                                </div>-->

                            </div>
                        </div>
                    </div> <!-- end col -->
    </div>
 <input type="hidden" name="userid" value="<?php echo $userid ?>" />
 <input type="submit" id="formSubmitBtn" style="display: none;"/>
</form>
