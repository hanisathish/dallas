<form method="post" action="{{ route('room.store') }}" name="create_room_form" id="create_room_form" enctype="multipart/form-data">
 <div id="create_room_form_status"></div>
    <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30" style="margin-bottom: 0">
                            <div class="card-body">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}">


                                 <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" required="" type="text" value="{{ isset($room)?$room->room_name:'' }}" id="room_name" name="room_name" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Room Owner</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" required="" type="text" value="{{ isset($room)?$room->room_owner:'' }}" id="room_owner" name="room_owner" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Contact</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" required="" type="text" value="{{ isset($room)?$room->contact_no:'' }}" id="contact_no" name="contact_no" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">E-mail</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" required="" type="text" value="{{ isset($room)?$room->contact_email:'' }}" id="contact_email" name="contact_email" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" required=""  value="{{ isset($room)?$room->room_desc:'' }}" id="room_desc" name="room_desc" >{{ isset($room)?$room->room_desc:'' }}</textarea>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Daigram</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="file" value="" id="room_image" name="room_image" >
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Group</label>
                                    <div class="col-sm-9">
                                        <select id="group_id" required="" name="group_id" class="form-control" value="{{ isset($room)?$room->group_id:'' }}">
                                           <option value=""> -- Select -- </option>
                                           @foreach($room_group as $value)
                                           <option value="{{$value->mldId}}" @if(isset($room) &&  $value->mldId == $room->group_id) selected @endif>{{$value->mldValue}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Building Number</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" required="" type="text" value="{{ isset($room)?$room->building_number:'' }}" id="building_number" name="building_number" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                        <label for="example-date-input" class="col-sm-3 col-form-label">Approval</label>
                                        <div class="col-sm-9">
                                            <select id="approval_group" name="approval_group" class="form-control" required="">
                                                <option value=""> -- Select -- </option>
                                                @foreach($roles as $value)
                                                <option value="{{$value->id}}" @if(isset($room) &&  $value->id == $room->approval_group) selected @endif>{{$value->name}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>





                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
 <input type="hidden" name="roomId" value="{{ isset($room)?$room->id:'' }}" />
 <input type="submit" id="formSubmitBtn" style="display: none;" />
</form>

