<form method="post" action="{{ route('group.member.store') }}" name="add_member_form" id="add_member_form" enctype="multipart/form-data">
    <div id="add_member_form_status"></div>
       <div class="row">

                       <div class="col-12">
                           <div class="card m-b-30" style="margin-bottom: 0">
                               <div class="card-body">
                                   <input name="_token" type="hidden" value="{{ csrf_token() }}">

                                    <div class="form-group row">

                                       <div class="col-sm-12">
                                          <input class="form-control" type="text" value="" id="user_id" name="user_id" autocomplete="off">
                                        <input type="hidden" name="selectedUser" id="selectedUser" />
                                       </div>
                                   </div>



                               </div>
                           </div>
                       </div> <!-- end col -->
                   </div>
    <input class="groupIdAddMember" type="hidden" name="groupId" id="groupId" value="" />
    <input type="submit" id="formSubmitBtn" style="display: none;" />
   </form>

