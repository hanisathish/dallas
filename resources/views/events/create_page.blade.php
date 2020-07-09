<form method="post" action="{{ route('events.store') }}" name="create_event_form" id="create_event_form">
 <div id="create_event_form_status"></div>
    <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-3 col-form-label">Title Event</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" required="" type="text" id="eventName" name="eventName" value="{{ isset($event)?$event->eventName:'' }}">
                                        <div class="row">
                                            <div class="col-md-4">
                                                Start Time:
                                                <select required="" id="eventStartCheckin" name="eventStartCheckin" class="form-control create-time" onchange="validateTime(this)">
                                                    <option value=""> -- Select -- </option>
                                                    <?php for($i = 1; $i <= 24; $i++): ?>
                                                    <?php $selected= isset($event)?($event->eventStartCheckin==date("H:i:s", strtotime("$i:00:00")))?'selected':'':''; ?>
                                                        <option value="<?= date("H:i", strtotime("$i:00")) ?>" {{$selected}}><?= date("h.iA", strtotime("$i:00")); ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                End Time:
                                                <select id="eventEndCheckin" required="" name="eventEndCheckin" class="form-control create-time" onchange="validateTime(this)">
                                                    <option value=""> -- Select -- </option>
                                                    <?php for($i = 1; $i <= 24; $i++): ?>
                                                    <?php $selected= isset($event)?($event->eventEndCheckin==date("H:i:s", strtotime("$i:00:00")))?'selected':'':''; ?>
                                                        <option value="<?= date("H:i", strtotime("$i:00")) ?>" {{$selected}}><?= date("h.iA", strtotime("$i:00")); ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                             <div class="col-md-4">
                                                Show Time:
                                                <select id="eventShowTime" required="" name="eventShowTime" class="form-control create-time" onchange="validateTime(this)">
                                                    <option value=""> -- Select -- </option>
                                                    <?php for($i = 1; $i <= 24; $i++): ?>
                                                    <?php $selected= isset($event)?($event->eventShowTime==date("H:i:s", strtotime("$i:00:00")))?'selected':'':''; ?>
                                                        <option value="<?= date("H:i", strtotime("$i:00")) ?>" {{$selected}}><?= date("h.iA", strtotime("$i:00")); ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Date</label>
                                    <div class="col-sm-9">
                                        <input required="" class="form-control" type="date" value="{{ isset($event)?$event->eventCreatedDate:'' }}" id="eventCreatedDate" name="eventCreatedDate" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <textarea name="eventDesc" id="eventDesc" class="form-control">{{ isset($event)?$event->eventDesc:'' }}</textarea>
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Occurence</label>
                                    <div class="col-sm-9">
                                        <select id="eventFreq" name="eventFreq" class="form-control" required="" value="{{ isset($event)?$event->eventFreq:'' }}">
                                            <option value="Daily" <?= isset($event)?($event->eventFreq=='Daily')?'selected':'':'' ?>>Daily</option>
                                            <option value="Weekly" <?= isset($event)?($event->eventFreq=='Weekly')?'selected':'':'' ?>>Weekly</option>
                                            <option value="None" <?= isset($event)?($event->eventFreq=='None')?'selected':'':'' ?>>None</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Child Care</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" value="" id="eventChildCare" name="eventChildCare" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Location</label>
                                    <div class="col-sm-9">
                                        <select id="eventLocation" name="eventLocation" class="form-control" required="">

                                            <option value=""> -- Select -- </option>
                                            @foreach($locations as $value)
                                            <option value="{{$value->id}}" @if(isset($event) &&  $event->eventLocation == $value->id) selected @endif>{{$value->name}}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Building Block</label>
                                    <div class="col-sm-9">
                                        <select id="eventBuildingBlock" name="eventBuildingBlock" class="form-control">
                                            <option value=""> -- Select -- </option>
                                            <option value="Daily">Daily</option>
                                            <option value="Weekly">Weekly</option>
                                            <option value="None">None</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Booked For</label>
                                    <div class="col-sm-9">
                                        <select id="eventBookedFor" name="eventBookedFor" class="form-control">
                                                rooms
                                            <option value="room1">Room 1</option>
                                            <option value="room2">Room 2</option>
                                        </select>

                                    </div>

                                </div>

                                 <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Room</label>
                                    <div class="col-sm-9">
                                        <select id="eventRoom" name="eventRoom" class="form-control">
                                                <option value="">-- Select --</option>
                                            @foreach($rooms as $value)
                                            <option value="{{$value->id}}" @if(isset($event) &&  $event->eventRoom == $value->id) selected @endif>{{$value->room_name}}</option>
                                            @endforeach


                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Suggested Resources</label>
                                    <div class="col-sm-9">
                                        <select id="eventSuggestedResources" name="eventSuggestedResources" class="form-control">
                                            <option value="Food Table">Food Table</option>
                                            <option value="Mobile">Mobile</option>
                                            <option value="Chair">Chair</option>
                                        </select>

                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Notification</label>
                                    <div class="col-sm-4">
                                        <label class="radio-inline"><input type="radio" name="eventNotification"  value="yes">Yes</label>


                                    </div>
                                    <div class="col-sm-4">

                                        <label class="radio-inline"><input type="radio" name="eventNotification" checked value="no">No</label>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
 <input type="hidden" name="eventId" value="{{ isset($event)?$event->eventId:'' }}" />
 <input type="submit" id="formSubmitBtn" style="display: none;"/>
</form>
