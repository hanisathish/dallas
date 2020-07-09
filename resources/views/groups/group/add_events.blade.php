<form method="post" action="{{ route('group.events.store') }}" name="create_event_form" id="create_event_form" enctype="multipart/form-data">
    <div id="create_event_form_status"></div>
       <div class="row">

                       <div class="col-12">
                           <div class="card m-b-30" style="margin-bottom: 0">
                               <div class="card-body">
                                   <input name="_token" type="hidden" value="{{ csrf_token() }}">


                                    <div class="form-group row">
                                       <label for="example-date-input" class="col-sm-3 col-form-label">Event Name:</label>
                                       <div class="col-sm-9">
                                           <input class="form-control" required="" type="text" value="{{ isset($event)?$event->title:'' }}" id="title" name="title" >
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <label for="example-date-input" class="col-sm-3 col-form-label">Event Start:</label>
                                       <div class="col-sm-6">
                                            <input class="form-control" required="" type="date" value="{{ isset($event)?$event->start_date:'' }}" id="start_date" name="start_date" >
                                       </div>
                                       <div class="col-sm-3">
                                            <select required="" id="start_time" name="start_time" class="form-control create-time" onchange="validateTime(this)">
                                                    <option value=""> -- Select -- </option>
                                                    <?php for($i = 1; $i <= 24; $i++): ?>
                                                    <?php $selected= isset($event)?($event->start_time==date("H:i:s", strtotime("$i:00:00")))?'selected':'':''; ?>
                                                        <option value="<?= date("H:i", strtotime("$i:00")) ?>" {{$selected}}><?= date("h.iA", strtotime("$i:00")); ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                        <label for="example-date-input" class="col-sm-3 col-form-label">Event End:</label>
                                        <div class="col-sm-6">
                                             <input class="form-control" required="" type="date" value="{{ isset($event)?$event->end_date:'' }}" id="end_date" name="end_date" >
                                        </div>
                                        <div class="col-sm-3">
                                             <select required="" id="end_time" name="end_time" class="form-control create-time" onchange="validateTime(this)">
                                                     <option value=""> -- Select -- </option>
                                                     <?php for($i = 1; $i <= 24; $i++): ?>
                                                     <?php $selected= isset($event)?($event->end_time==date("H:i:s", strtotime("$i:00:00")))?'selected':'':''; ?>
                                                         <option value="<?= date("H:i", strtotime("$i:00")) ?>" {{$selected}}><?= date("h.iA", strtotime("$i:00")); ?></option>
                                                     <?php endfor; ?>
                                                 </select>
                                        </div>
                                    </div>

                                   <div class="row form-group">

                                        <div class="col-sm-9">
                                                <input class="checkbox" type="checkbox"  name="isMutiDay_event" id="isMutiDay_event" {{isset($event)?($event->isMutiDay_event=='1')?'checked':'':''}}>
                                                <label class="checkbox-label" for="isMutiDay_event" >This is a multi-day event</label>
                                            </div>

                                </div>



                                <div class="form-group row">
                                        <label for="example-date-input" class="col-sm-3 col-form-label"> Repeat:</label>

                                        <div class="col-sm-9">
                                                <select id="repeat" name="repeat" class="form-control" required="">
                                                        <option value=""> -- Select -- </option>
                                                        <option value="never" <?= isset($event)?($event->repeat=='never')?'selected':'':'' ?>>Never</option>
                                                        <option value="weekly" <?= isset($event)?($event->repeat=='weekly')?'selected':'':'' ?>>Weekly</option>
                                                        <option value="biweekly" <?= isset($event)?($event->repeat=='biweekly')?'selected':'':'' ?>>Every other week</option>
                                                        <option value="monthly" <?= isset($event)?($event->repeat=='monthly')?'selected':'':'' ?>>Monthly</option>
                                                        <option value="yearly" <?= isset($event)?($event->repeat=='yearly')?'selected':'':'' ?>>Yearly</option>
                                                    </select>
                                    </div>


                                </div>



                                   <div class="form-group row">
                                       <label for="example-date-input" class="col-sm-3 col-form-label">Location</label>
                                       <div class="col-sm-9">

                                            <select id="location" name="location" class="form-control" required="">

                                                    <option value=""> -- Select -- </option>
                                                    @foreach($locations as $value)
                                                    <option value="{{$value->id}}" @if(isset($event) &&  $event->location == $value->id) selected @endif>{{$value->name}}</option>
                                                    @endforeach

                                                </select>


                                       </div>
                                   </div>

                                   <div class="form-group row">
                                        <label for="example-date-input" class="col-sm-3 col-form-label">Description</label>
                                        <div class="col-sm-9">
                                            <textarea name="description" id="description" class="form-control">{{ isset($event)?$event->description:'' }}</textarea>
                                        </div>
                                    </div>




                               </div>
                           </div>
                       </div> <!-- end col -->
                   </div>
    <input type="hidden" name="eventId" value="{{ isset($event)?$event->id:'' }}" />
    <input type="hidden" name="group_id" value="{{ $groupId }}" />
    <input type="submit" id="formSubmitBtn" style="display: none;" />
   </form>

   <script>

function validateTime(elm){

                //$(".create-time option").attr("disabled",false);

                if(elm.id=="start_time"){
                    var index = $("#start_time option:selected").index();
                    $("#end_time option").eq(0).prop('selected', true);


                    $("#end_time option").attr("disabled",false);


                    $("#end_time option:lt("+(index+1)+")").attr('disabled',true);

                }
                if(elm.id=="end_time"){
                    var index = $("#end_time option:selected").index();

                    //$("#start_time option").eq(0).prop('selected', true);

                     $("#start_time option").attr("disabled",false);
                    $("#start_time option:gt("+(index-1)+")").attr('disabled',true);
                }

            }
        $(document).ready(function() {
               $("#item_year").datepicker({
                       format: "yyyy",
                       viewMode: "years",
                       minViewMode: "years"
                   });
               });
   </script>
