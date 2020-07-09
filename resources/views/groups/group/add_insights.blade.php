
<ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#file" data-tab="1">File Upload
    </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#url" data-tab="2"> URL Link
    </a>
    </li>

  </ul>
<form method="post" action="{{ route('group.insights.store') }}" name="create_resources_form" id="create_resources_form" enctype="multipart/form-data">
    <div id="create_resources_form_status"></div>
       <div class="row">

                       <div class="col-12">
                           <div class="card m-b-30" style="margin-bottom: 0">
                               <div class="card-body">
                                   <input name="_token" type="hidden" value="{{ csrf_token() }}">

                                   <div class="tab-content">
                                    <div class="tab-pane container active" id="file">


                                    <div class="form-group row">
                                       <label for="example-date-input" class="col-sm-3 col-form-label">File:</label>
                                       <div class="col-sm-9">
                                           <input class="form-control"  type="file" value="" id="file" name="file" >
                                       </div>
                                       <label for="example-date-input" class="col-md-12 col-form-label">{{ isset($resource)?$resource->source:'' }}</label>
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

                                <div class="form-group row">
                                        <label for="example-date-input" class="col-sm-3 col-form-label"> Visibility:</label>

                                        <div class="col-sm-9">
                                                <select id="visibility" name="visibility" class="form-control" >

                                                        <option value="1" <?= isset($resource)?($resource->visibility=='1')?'selected':'':'' ?>>Leaders</option>
                                                        <option value="2" <?= isset($resource)?($resource->visibility=='2')?'selected':'':'' ?>>Members</option>

                                                    </select>
                                    </div>


                                </div>

                                    </div>




                                <!-- tab2 -->


                                    <div class="tab-pane container" id="url">

                                            <div class="form-group row">
                                                    <label for="example-date-input" class="col-sm-3 col-form-label">Link:</label>
                                                    <div class="col-sm-9">
                                                        <input class="form-control"  type="url" value="{{ isset($resource)?$resource->source:'' }}" id="source" name="source" >
                                                    </div>
                                                </div>


                                            <div class="form-group row">
                                                    <label for="example-date-input" class="col-sm-3 col-form-label">Name:</label>
                                                    <div class="col-sm-9">
                                                        <input class="form-control"  type="text" value="{{ isset($resource)?$resource->name:'' }}" id="url_name" name="url_name" >
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                 <label for="example-date-input" class="col-sm-3 col-form-label">Description</label>
                                                 <div class="col-sm-9">
                                                     <textarea name="url_description" id="url_description" class="form-control">{{ isset($resource)?$resource->description:'' }}</textarea>
                                                 </div>
                                             </div>

                                             <div class="form-group row">
                                                     <label for="example-date-input" class="col-sm-3 col-form-label"> Visibility:</label>

                                                     <div class="col-sm-9">
                                                             <select id="url_visibility" name="url_visibility" class="form-control" required="">

                                                                     <option value="1" <?= isset($resource)?($resource->visibility=='1')?'selected':'':'' ?>>Leaders</option>
                                                                     <option value="2" <?= isset($resource)?($resource->visibility=='2')?'selected':'':'' ?>>Members</option>

                                                                 </select>
                                                 </div>


                                             </div>
                                    </div>
                                </div>





                               </div>
                           </div>
                       </div> <!-- end col -->
                   </div>
    <input type="hidden" name="resourceId" value="{{ isset($resource)?$resource->id:'' }}" />
    <input type="hidden" name="group_id" value="{{ $groupId }}" />
    <input type="hidden" name="type"  id="type" value="{{ isset($resource)?$resource->type:'1' }}" />
    <input type="submit" id="formSubmitBtn" style="display: none;" />
   </form>

   <script>

$(document).ready(function(){
$(".nav-link").click(function(){
    $("#type").val($(this).attr("data-tab"));
});

<?php if(isset($resource)) { ?>
    $("a[data-tab='<?= $resource->type ?>']").click();
    $(".modal  .nav-tabs").hide();
    <?php if($resource->type==1) {  ?>
     $("#url").empty();
    <?php } ?>
    <?php  } ?>
});


   </script>
