<form method="post" action="{{ route('group_type.store') }}" class="d_form" name="create_group_type_form" id="create_group_type_form" enctype="multipart/form-data">
    <div id="create_resource_form_status"></div>
       <div class="row">

                       <div class="col-12">
                           <div class="card m-b-30 " style="margin-bottom: 0">
                               <div class="card-body">
                                   <input name="_token" type="hidden" value="{{ csrf_token() }}">

                                   <h6 class="fs-2 mb-2">Basic Settings</h6>
                                   <div class="card pane">
                                        <div class="card-body">

                                        <div class="form-group row">
                                            <label for="example-date-input" class="col-sm-3 col-form-label">Meeting schedule</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" required="" type="text" value="{{ isset($groupType)?$groupType->d_meeting_schedule:'' }}" id="d_meeting_schedule" name="d_meeting_schedule" >
                                            </div>
                                        </div>


                                    <div class="form-group row">
                                            <label for="example-date-input" class="col-sm-3 col-form-label">Description</label>
                                            <div class="col-sm-9">
                                                <textarea rows="4" required name="d_description" id="d_description" class="form-control">{{ isset($groupType)?$groupType->d_description:'' }}</textarea>
                                            </div>
                                        </div>

                                </div>
                            </div>



                            <h6 class="fs-2 mb-2">Location Settings</h6>
                                   <div class="card pane">
                                        <div class="card-body">

                                        <div class="form-group row">
                                            <label for="example-date-input" class="col-sm-3 col-form-label">Location</label>
                                            <div class="col-sm-9">

                                                    <select id="d_location" name="d_location" class="form-control" required="">
                                                            <option value=""> -- Select -- </option>

                                                            @foreach($locations as $value)
                                                                <option value="{{$value->id}}" @if(isset($groupType) &&  $groupType->d_location == $value->id) selected @endif>{{$value->name}}</option>
                                                            @endforeach

                                                           </select>

                                                  </div>
                                        </div>



                                </div>
                            </div>

                            <h6 class="fs-2 mb-2">Contact Person</h6>
                            <div class="card pane">
                                 <div class="card-body">

                                 <div class="form-group row">
                                     <label for="example-date-input" class="col-sm-3 col-form-label">Contact email</label>
                                     <div class="col-sm-9">
                                         <input class="form-control"  type="email" value="{{ isset($groupType)?$groupType->d_contact_email:'' }}" id="d_contact_email" name="d_contact_email" >
                                     </div>
                                 </div>
                                </div>
                            </div>

                            <h6 class="fs-2 mb-2">Member Visibility</h6>
                            <div class="card pane">
                                 <div class="card-body">

                                 <div class="form-group row">
                                     <label for="example-date-input" class="col-sm-7 col-form-label">Members can see leader's:</label>
                                     <div class="col-sm-5">
                                            <div class="dropdown">
                                                    <button class="btn btn-default dropdown-toggle" type="button"
                                                            id="dropdownMenu1" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="true">
                                                      <i class="glyphicon glyphicon-cog"></i>
                                                      <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu checkbox-menu allow-focus" aria-labelledby="dropdownMenu1">

                                                     <?php $fields = ["name","photo","email","phone"]; ?>

                                                        @foreach($fields as $field)
                                                        <?php
                                                            $checked = "";
                                                         if(isset($groupType)){
                                                                $d_visible_leaders_fields = json_decode($groupType->d_visible_leaders_fields);
                                                                    if( $d_visible_leaders_fields &&  in_array($field, $d_visible_leaders_fields))
                                                                        $checked = "checked";
                                                          } ?>
                                                        <li >
                                                            <label>
                                                              <input  type="checkbox" {{$checked}} name="d_visible_leaders_fields[]" value="{{$field}}"> {{$field}}
                                                            </label>
                                                          </li>
                                                        @endforeach

                                                    </ul>
                                                  </div>
                                     </div>
                                 </div>

                                 <div class="form-group row">
                                        <label for="example-date-input" class="col-sm-7 col-form-label">Members can see other member's:
                                            </label>
                                        <div class="col-sm-5">
                                               <div class="dropdown">
                                                       <button class="btn btn-default dropdown-toggle" type="button"
                                                               id="dropdownMenu2" data-toggle="dropdown"
                                                               aria-haspopup="true" aria-expanded="true">
                                                         <i class="glyphicon glyphicon-cog"></i>
                                                         <span class="caret"></span>
                                                       </button>
                                                       <ul class="dropdown-menu checkbox-menu allow-focus" aria-labelledby="dropdownMenu1">

                                                        <?php $fields = ["name","photo","email","phone"]; ?>

                                                        @foreach($fields as $field)
                                                        <?php
                                                            $checked = "";
                                                         if(isset($groupType)){
                                                                $d_visible_members_fields = json_decode($groupType->d_visible_members_fields);
                                                                    if( $d_visible_members_fields &&  in_array($field, $d_visible_members_fields))
                                                                        $checked = "checked";
                                                          } ?>
                                                        <li >
                                                            <label>
                                                              <input  type="checkbox" {{$checked}} name="d_visible_members_fields[]" value="{{$field}}"> {{$field}}
                                                            </label>
                                                          </li>
                                                        @endforeach





                                                       </ul>
                                                     </div>
                                        </div>
                                    </div>



                                </div>
                            </div>

                            <h6 class="fs-2 mb-2">Enrollment Settings</h6>
                            <div class="card pane">
                                 <div class="card-body">

                                 <div class="form-group row">
                                        <input type="checkbox" value="1" name="d_is_enroll_autoClose" class="checkbox " id="d_is_enroll_autoClose" onchange="enableInput(this)" >
                                     <label for="d_is_enroll_autoClose" class="checkbox-label col-sm-7">Auto-close enrollment on:</label>
                                     <div class="col-sm-5">
                                         <input type="date" class="form-control" name="d_enroll_autoClose_on" id="d_enroll_autoClose_on" value="{{(isset($groupType) && $groupType->d_enroll_autoClose_on !="")?$groupType->d_enroll_autoClose_on:'' }}"  disabled />
                                     </div>
                                    </div>

                                    <div class="form-group row">
                                            <input type="checkbox" value="1" name="d_is_enroll_autoClose_count" class="checkbox " id="d_is_enroll_autoClose_count" onchange="enableInput(this)" >
                                         <label for="d_is_enroll_autoClose_count" class="checkbox-label col-sm-7">Auto-close if enrollment number reaches
                                            </label>
                                         <div class="col-sm-5">
                                             <input type="number" class="form-control" name="d_enroll_autoClose_count" id="d_enroll_autoClose_count" value="{{isset($groupType)?$groupType->d_enroll_autoClose_count:'' }}" disabled />
                                         </div>
                                        </div>

                                        <div class="form-group row">
                                                <input type="checkbox" value="1" name="d_is_enroll_notify_count" class="checkbox " id="d_is_enroll_notify_count"  onchange="enableInput(this)">
                                             <label for="d_is_enroll_notify_count" class="checkbox-label col-sm-7">Create alert if group membership exceeds

                                                </label>
                                             <div class="col-sm-5">
                                                 <input type="number" class="form-control" id="d_enroll_notify_count" name="d_enroll_notify_count" value="{{isset($groupType)?$groupType->d_enroll_notify_count:'' }}" disabled />
                                             </div>
                                            </div>
                                </div>
                            </div>




                               </div>
                           </div>
                       </div> <!-- end col -->
                   </div>
    <input type="hidden" name="groupTypeId" value="{{ isset($groupType)?$groupType->id:'' }}" />
    <input type="submit" id="formSubmitBtn" style="display: none;" />
   </form>
<script>
    $(document).ready(function(){
    $(".checkbox-menu").on("change", "input[type='checkbox']", function() {
   $(this).closest("li").toggleClass("active", this.checked);
});

$(document).on('click', '.allow-focus', function (e) {
  e.stopPropagation();
});


<?php
    $fields = ["d_is_enroll_autoClose","d_is_enroll_autoClose_count","d_is_enroll_notify_count"];
    if(isset($groupType)) {
        foreach($fields as $field) {
            if($groupType->$field ==1) { ?>
            $("#<?= $field ?>").attr("checked",true).change();
           <?php }
        }

    }
?>

});

function enableInput(elm){
    var input = $(elm).parent().closest("div").find("input.form-control");

    if($(elm).prop("checked") == true){
        $(input).attr("disabled",false);
    }
    else {
        $(input).attr("disabled",true);
    }
}
</script>

