<form method="post" action="{{ route('groups.storeContactMessage') }}" name="send_contact_group" id="send_contact_group" enctype="multipart/form-data">
 <div id="send_contact_group_status"></div>

        <div class="row">    
                    <div class="col-12">
                        <div class="card m-b-30" style="margin-bottom: 0">
                            <div class="card-body">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}">
								<div class="form-group row">
                                   <label for="example-date-input" class="col-sm-12 col-form-label"><h4>Send Message</h4></label>
                                </div>

                                    <div class="form-group row">                                        
                                        <label for="example-date-input" class="col-sm-3 col-form-label">Name</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" required="" type="text" value="" id="contact_name" name="contact_name">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                            <label for="example-date-input" class="col-sm-3 col-form-label">E-Mail Address</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" required="" type="text" value="" id="contact_email" name="contact_email">
                                            </div>
                                    </div>

                                    <div class="form-group row">
                                            <label for="example-date-input" class="col-sm-3 col-form-label">Message</label>
                                            <div class="col-sm-9">
                                            <textarea id="contact_message" name="contact_message" class="form-control" maxlength="225" rows="3" placeholder=""></textarea>
                                            </div>
                                    </div>

                            </div>
                        </div>
                    </div> <!-- end col -->
       </div>

 <input class="form-control" type="hidden" value="<?php echo $orgID ?>" id="orgId" name="orgId">
 <input class="form-control" type="hidden" value="<?php echo $groupid ?>" id="group_id" name="group_id">

 <input type="submit" id="formContactBtn" style="display: none;" />
</form>

