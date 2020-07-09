<form method="post" action="{{ route('group_type.store') }}" name="create_group_type_form" id="create_group_type_form" enctype="multipart/form-data">
    <div id="create_resource_form_status"></div>
       <div class="row">

                       <div class="col-12">
                           <div class="card m-b-30" style="margin-bottom: 0">
                               <div class="card-body">
                                   <input name="_token" type="hidden" value="{{ csrf_token() }}">


                                    <div class="form-group row">
                                       <label for="example-date-input" class="col-sm-3 col-form-label">Group Type Name</label>
                                       <div class="col-sm-9">
                                           <input class="form-control" required="" type="text" value="{{ isset($groupType)?$groupType->name:'' }}" id="name" name="name" >
                                       </div>
                                   </div>



                                   <div class="form-group row">
                                       <label for="example-date-input" class="col-sm-3 col-form-label">Description</label>
                                       <div class="col-sm-9">
                                           <textarea rows="4" required name="description" id="description" class="form-control">{{ isset($groupType)?$groupType->description:'' }}</textarea>
                                       </div>
                                   </div>


                                   <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Groups list map</label>
                                    <div class="col-sm-9">
                                        <input class="checkbox" type="checkbox" checked="checked" name="isPublic" id="isPublic">
                                        <label class="checkbox-label" for="isPublic">Enable map view on public groups list page</label>
                                    </div>
                                </div>





                               </div>
                           </div>
                       </div> <!-- end col -->
                   </div>
    <input type="hidden" name="groupTypeId" value="{{ isset($groupType)?$groupType->id:'' }}" />
    <input type="submit" id="formSubmitBtn" style="display: none;" />
   </form>


