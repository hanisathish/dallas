
<form method="post" action="{{ route('groups.store') }}" name="create_group_form" id="create_group_form" enctype="multipart/form-data">
    <div id="create_group_form_status"></div>
    <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30" style="margin-bottom: 0">
                            <div class="card-body">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}">


                                    <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Group Type:</label>
                                    <div class="col-sm-9">
                                        <select class="form-control"  id="add_group_type" name="add_group_type" required="">
                                            <option value="">-- Select --</option>
                                            @foreach($groupTypes as $groupType)
                                                <option value="{{$groupType->id}}">{{$groupType->name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Group Name:</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" required="" type="text" value="" id="add_group_name" name="add_group_name">
                                    </div>
                                </div>





                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
    <input type="hidden" name="groupTypeId" value="">
    <input type="submit" id="formSubmitBtn" style="display: none;">
</form>
