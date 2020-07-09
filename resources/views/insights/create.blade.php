<form method="post" action="{{ route('room.store') }}" name="create_room_form" id="create_room_form" enctype="multipart/form-data">
 <div id="create_room_form_status"></div>
    <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30" style="margin-bottom: 0">
                            <div class="card-body">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}">


                                   <div class="form-group row">
                                        <label for="example-date-input" class="col-sm-3 col-form-label"> Type:</label>
                                        <div class="col-sm-9">
                                                <select id="type" name="type" class="form-control" >
                                                        <option value="1" <?= isset($resource)?($resource->type=='1')?'selected':'':'' ?>>File</option>
                                                        <option value="2" <?= isset($resource)?($resource->type=='2')?'selected':'':'' ?>>URL Path</option>
                                                 </select>
                                        </div>
							        </div>
								
								    
									<div id="dvFile" style="display: none">								
										<div class="form-group row">
										   <label for="example-date-input" class="col-sm-3 col-form-label">File:</label>
										   <div class="col-sm-9">
											   <input class="form-control"  type="file" value="" id="file" name="file" >
										   </div>
										   <label for="example-date-input" class="col-md-12 col-form-label">{{ isset($resource)?$resource->source:'' }}</label>
									   </div>
								 	</div>
								   
								  <div id="dvLink" style="display: none">	
										<div class="form-group row">
												<label for="example-date-input" class="col-sm-3 col-form-label">Link:</label>
												<div class="col-sm-9">
													<input class="form-control"  type="url" value="{{ isset($resource)?$resource->source:'' }}" id="source" name="source" >
												</div>
										</div>								   
								   </div>

                                   <div class="form-group row">
                                       <label for="example-date-input" class="col-sm-3 col-form-label">Name:</label>
                                       <div class="col-sm-9">
                                           <input class="form-control"  type="text" value="{{ isset($resource)?$resource->name:'' }}" id="name" name="name" >
                                       </div>
                                   </div>

                                   <div class="form-group row">
										<label for="example-date-input" class="col-sm-3 col-form-label">Description</label>
										<div class="col-sm-9">
											<textarea name="description" id="description" class="form-control">{{ isset($resource)?$resource->description:'' }}</textarea>
										</div>
                                  </div>

                                <div class="form-group row" style="display: none;">
                                        <label for="example-date-input" class="col-sm-3 col-form-label"> Visibility:</label>
                                        <div class="col-sm-9">
                                                <select id="visibility" name="visibility" class="form-control" >
                                                        <option value="1" <?= isset($resource)?($resource->visibility=='1')?'selected':'':'' ?>>Leaders</option>
                                                        <option value="2" <?= isset($resource)?($resource->visibility=='2')?'selected':'':'' ?>>Members</option>
                                                 </select>
                                        </div>
							    </div>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
 <input type="hidden" name="insightId" value="{{ isset($resource)?$resource->id:'' }}" />
 <input type="submit" id="formSubmitBtn" style="display: none;" />
</form>

<script>
$(function () {
	$("#type").change(function () {
		if ($(this).val() == "2") {
			$("#dvLink").show();
		} else {
			$("#dvLink").hide();
		}
	});
 });
 
 $(function () {
	$("#type").change(function () {
		if ($(this).val() == "1") {
			$("#dvFile").show();
		} else {
			$("#dvFile").hide();
		}
	});
 });
</script>