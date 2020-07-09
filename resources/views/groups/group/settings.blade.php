<div class="col-lg-9">
    <div class="card m-b-30">
        <div class="card-header">
            Members Information
        </div>
        <div class="card-body">
            <div class="col-12">
                <div class="row">


                        <div class="tab-content" id="v-pills-tabContent" style="width: 100%">
                            <form method="post" action="{{ route('group_settings.store') }}" class="d_form" name="group_settings_form" id="group_settings_form" enctype="multipart/form-data">
                                <div id="group_settings_form_status"></div>
                                   <div class="row">

                                                   <div class="col-12">
                                                       <div class="card m-b-30 " style="margin-bottom: 0">
                                                           <div class="card-body">
                                                               <input name="_token" type="hidden" value="{{ csrf_token() }}">

                                                               <h6 class="fs-2 mb-2">Basic Settings</h6>
                                                               <div class="card pane col-md-12">
                                                                    <div class="card-body">
                                                                            <div class=" row">
                                                                    <div class="col-md-8">
                                                                    <div class="form-group row">
                                                                        <label for="example-date-input" class="col-sm-3 col-form-label">Meeting schedule</label>
                                                                        <div class="col-sm-9">
                                                                            <input class="form-control" required="" type="text" value="{{ isset($groupDetails)?$groupDetails->meeting_schedule:'' }}" id="meeting_schedule" name="meeting_schedule" >
                                                                        </div>
                                                                    </div>


                                                                <div class="form-group row">
                                                                        <label for="example-date-input" class="col-sm-3 col-form-label">Description</label>
                                                                        <div class="col-sm-9">
                                                                            <textarea rows="4" required name="description" id="description" class="form-control">{{ isset($groupDetails)?$groupDetails->description:'' }}</textarea>
                                                                        </div>
                                                                    </div>

                                                            </div>
                                                            <div class="col-md-4">
                                                                    <div class="form-group row">
                                                                            <img class="d-flex mr-3 " id="group-img" src="{{$groupDetails->img}}" alt="Generic placeholder image" height="128" />

                                                                            <div  class="col-md-12" >
                                                                                <input type="button" class="btn btn-outline-primary btn-sm my-md-2" onclick="uploadImage()" value="Upload Image" />
                                                                            </div>

                                                                        </div>
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

                                                                                <select id="location" name="location" class="form-control" required="">
                                                                                        <option value=""> -- Select -- </option>

                                                                                        @foreach($locations as $value)
                                                                                            <option value="{{$value->id}}" @if(isset($groupDetails) &&  $groupDetails->location == $value->id) selected @endif>{{$value->name}}</option>
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
                                                                     <input class="form-control"  type="email" value="{{ isset($groupDetails)?$groupDetails->contact_email:'' }}" id="contact_email" name="contact_email" >
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
                                                                                     if(isset($groupDetails)){
                                                                                            $visible_leaders_fields = json_decode($groupDetails->visible_leaders_fields);
                                                                                                if( $visible_leaders_fields &&  in_array($field, $visible_leaders_fields))
                                                                                                    $checked = "checked";
                                                                                      } ?>
                                                                                    <li >
                                                                                        <label>
                                                                                          <input  type="checkbox" {{$checked}} name="visible_leaders_fields[]" value="{{$field}}"> {{$field}}
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
                                                                                     if(isset($groupDetails)){
                                                                                            $visible_members_fields = json_decode($groupDetails->visible_members_fields);
                                                                                                if( $visible_members_fields &&  in_array($field, $visible_members_fields))
                                                                                                    $checked = "checked";
                                                                                      } ?>
                                                                                    <li >
                                                                                        <label>
                                                                                          <input  type="checkbox" {{$checked}} name="visible_members_fields[]" value="{{$field}}"> {{$field}}
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
                                                                    <input type="checkbox" value="1" name="is_enroll_autoClose" class="checkbox " id="is_enroll_autoClose" onchange="enableInput(this)" >
                                                                 <label for="is_enroll_autoClose" class="checkbox-label col-sm-7">Auto-close enrollment on:</label>
                                                                 <div class="col-sm-5">
                                                                     <input type="date" class="form-control" name="enroll_autoClose_on" id="enroll_autoClose_on" value="{{(isset($groupDetails) && $groupDetails->enroll_autoClose_on !="")?$groupDetails->enroll_autoClose_on:'' }}"  disabled />
                                                                 </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                        <input type="checkbox" value="1" name="is_enroll_autoClose_count" class="checkbox " id="is_enroll_autoClose_count" onchange="enableInput(this)" >
                                                                     <label for="is_enroll_autoClose_count" class="checkbox-label col-sm-7">Auto-close if enrollment number reaches
                                                                        </label>
                                                                     <div class="col-sm-5">
                                                                         <input type="number" class="form-control" name="enroll_autoClose_count" id="enroll_autoClose_count" value="{{isset($groupDetails)?$groupDetails->enroll_autoClose_count:'' }}" disabled />
                                                                     </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                            <input type="checkbox" value="1" name="is_enroll_notify_count" class="checkbox " id="is_enroll_notify_count"  onchange="enableInput(this)">
                                                                         <label for="is_enroll_notify_count" class="checkbox-label col-sm-7">Create alert if group membership exceeds

                                                                            </label>
                                                                         <div class="col-sm-5">
                                                                             <input type="number" class="form-control" id="enroll_notify_count" name="enroll_notify_count" value="{{isset($groupDetails)?$groupDetails->enroll_notify_count:'' }}" disabled />
                                                                         </div>
                                                                        </div>
                                                            </div>
                                                        </div>




                                                           </div>
                                                       </div>
                                                   </div> <!-- end col -->
                                               </div>
                                            <input type="hidden" name="groupId" value="{{$groupId}}" />
                                <input type="submit" value="Save" class="btn btn-primary" id="formSubmitBtn" style="display: block;" />
                               </form>

                               <form style="display: none" method="post" action="{{ route('group_settings.image.store') }}" class="d_form" name="group_settings_image_form" id="group_settings_image_form" enctype="multipart/form-data">
                               <input type="file" name="group-image" id="group-image" />
                               <input type="hidden" name="groupId" value="{{$groupId}}" />
                               <input type="submit" class="btn btn-primary" id="imgSubmitBtn" />
                                </form>
                            <script>
                                $(document).ready(function(){



                $('#group_settings_form').ajaxForm(function(data) {
                   $("#group_settings_form_status").html(data.message);
                   setTimeout(function(){

                    },2000);
                });


                $('#group_settings_image_form').ajaxForm(function(data) {

                   setTimeout(function(){
                        $("#group-img").attr("src",data.image);
                    },100);
                });

                $("#group-image").change(function(){
                    $("#imgSubmitBtn").click();
                });



                                $(".checkbox-menu").on("change", "input[type='checkbox']", function() {
                               $(this).closest("li").toggleClass("active", this.checked);
                            });

                            $(document).on('click', '.allow-focus', function (e) {
                              e.stopPropagation();
                            });


                            <?php
                                $fields = ["is_enroll_autoClose","is_enroll_autoClose_count","is_enroll_notify_count"];
                                if(isset($groupDetails)) {
                                    foreach($fields as $field) {
                                        if($groupDetails->$field ==1) { ?>
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

                            function uploadImage(){
                                $('#group-image').trigger('click');
                            }
                            </script>
                        </div>
                </div>
            </div>
        </div>

    </div>
</div>
