<form method="post" action="{{ route('resource.store') }}" name="create_resource_form" id="create_resource_form" enctype="multipart/form-data">
 <div id="create_resource_form_status"></div>
    <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30" style="margin-bottom: 0">
                            <div class="card-body">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}">


                                 <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Item Name</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" required="" type="text" value="{{ isset($resource)?$resource->item_name:'' }}" id="item_name" name="item_name" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Category</label>
                                    <div class="col-sm-9">
                                        <select id="category_id" required="" name="category_id" class="form-control" value="{{ isset($resource)?$resource->category_id:'' }}">
                                           <option value=""> -- Select -- </option>
                                           @foreach($category as $value)
                                           <option value="{{$value->mldId}}" @if(isset($resource) &&  $value->mldId == $resource->category_id) selected @endif>{{$value->mldValue}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <textarea name="item_desc" id="item_desc" class="form-control">{{ isset($resource)?$resource->item_desc:'' }}</textarea>
                                    </div>
                                </div>




                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Location</label>
                                    <div class="col-sm-9">
                                        <select id="location_id" name="location_id" class="form-control" required="">
                                            <option value=""> -- Select -- </option>

                                            @foreach($locations as $value)
                                                <option value="{{$value->id}}" @if(isset($resource) &&  $resource->location_id == $value->id) selected @endif>{{$value->name}}</option>
                                            @endforeach

                                           </select>

                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Year</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" value="{{ isset($resource)?$resource->item_year:'' }}" id="item_year" name="item_year" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Model</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" value="{{ isset($resource)?$resource->item_model:'' }}" id="item_model" name="item_model" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Last Service Date</label>
                                    <div class="col-sm-3">
                                       <input class="form-control" type="date" value="{{ isset($resource)?$resource->last_service_date:'' }}" id="last_service_date" name="last_service_date" >

                                    </div>
                                     <label for="example-date-input" class="col-sm-3 col-form-label">Next Service Date</label>
                                    <div class="col-sm-3">
                                       <input class="form-control" type="date" value="{{ isset($resource)?$resource->next_service_date:'' }}" id="next_service_date" name="next_service_date" >

                                    </div>

                                </div>



                                 <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Notification Period</label>
                                    <div class="col-sm-9">
                                       <input class="form-control" type="text" value="{{ isset($resource)?$resource->notification_period:'' }}" id="notification_period" name="notification_period" >

                                    </div>
                                </div>

                                   <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Photo</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="file" value="" id="item_photo" name="item_photo" >
                                    </div>
                                </div>

                               <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Criticality</label>
                                    <div class="col-sm-3">
                                        <select id="coa" name="coa" class="form-control" required="">
                                           <option value=""> -- Select -- </option>
                                            <option value="High" <?= isset($resource)?($resource->coa=='High')?'selected':'':'' ?>>High</option>
                                            <option value="Low" <?= isset($resource)?($resource->coa=='Low')?'selected':'':'' ?>>Low</option>
                                            <option value="Medium" <?= isset($resource)?($resource->coa=='Medium')?'selected':'':'' ?>>Medium</option>
                                        </select>

                                    </div>
                                     <label for="example-date-input" class="col-sm-3 col-form-label">Risk of Damage</label>
                                    <div class="col-sm-3">
                                        <select id="rod" name="rod" class="form-control" required="">
                                          <option value=""> -- Select -- </option>
                                           <option value="High" <?= isset($resource)?($resource->rod=='High')?'selected':'':'' ?>>High</option>
                                            <option value="Low" <?= isset($resource)?($resource->rod=='Low')?'selected':'':'' ?>>Low</option>
                                            <option value="Medium" <?= isset($resource)?($resource->rod=='Medium')?'selected':'':'' ?>>Medium</option>
                                        </select>

                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Approval</label>
                                    <div class="col-sm-9">
                                        <select id="approval_group" name="approval_group" class="form-control" required="">
                                            <option value=""> -- Select -- </option>
                                            @foreach($roles as $value)
                                            <option value="{{$value->id}}" @if(isset($resource) &&  $value->id == $resource->approval_group) selected @endif>{{$value->name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row">
                                        <label for="example-date-input" class="col-sm-3 col-form-label">Quantity</label>
                                        <div class="col-sm-9">
                                           <input class="form-control" type="number" value="{{ isset($resource)?$resource->quantity:'' }}" id="quantity" name="quantity" required >

                                        </div>
                                    </div>


                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
 <input type="hidden" name="resourceId" value="{{ isset($resource)?$resource->id:'' }}" />
 <input type="submit" id="formSubmitBtn" style="display: none;" />
</form>

<script>
     $(document).ready(function() {
            $("#item_year").datepicker({
                    format: "yyyy",
                    viewMode: "years",
                    minViewMode: "years"
                });
            });
</script>
