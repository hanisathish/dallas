@extends('layouts.default')

@section('content')
<link href="{{ URL::asset('assets/select2/select2.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ URL:: asset('assets/select2/select2.js')}}"></script>
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group pull-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item active">Compose New Message</li>
                            </ol>
                        </div>
                        <!--<h4 class="page-title">Roles Management</h4>-->
                        <!--<a href="{{URL::asset('role_create')}}" type="button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-plus"></i>Add Role</a>-->
                    </div>
                </div>
            </div>
            <!-- end page title end breadcrumb -->

            <div class="row">
                    <div class="col-lg-3">
                        <div class="card m-b-30">
                            
                                <div class="card-body p-0">
                                  <ul class="nav nav-pills flex-column">
                                    <li class="nav-item active">
                                      <a href="{{asset('/settings/message/create_page')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i> Compose
                                      </a>
                                    </li>
                                    <!-- <li class="nav-item">
                                      <a href="{{URL::asset('settings/messages')}}" class="nav-link">
                                        <i class="fa fa-inbox"></i> Inbox
                                        <span class="badge bg-warning float-right" style="color: #fff;">12</span>
                                      </a>
                                    </li>
                                    <li class="nav-item">
                                      <a href="#" class="nav-link">
                                        <i class="fa fa-envelope-o"></i> Sent
                                      </a>
                                    </li> -->
                                    <!-- <li class="nav-item">
                                      <a href="#" class="nav-link">
                                        <i class="fa fa-file-text-o"></i> Drafts
                                      </a>
                                    </li>
                                    <li class="nav-item">
                                      <a href="#" class="nav-link">
                                        <i class="fa fa-filter"></i> Junk
                                        <span class="badge bg-warning float-right">65</span>
                                      </a>
                                    </li>
                                    <li class="nav-item">
                                      <a href="#" class="nav-link">
                                        <i class="fa fa-trash-o"></i> Trash
                                      </a>
                                    </li> -->
                                  </ul>
                                
                                 
                            </div>
                        </div>
                    </div>
            <div class="col-lg-9">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <h4 class="mt-0 header-title">Compose New Message</h4>

                                @if($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ $message }}</strong>
                                </div>
                                @endif
                                <!-- -->
                                <form method="post" enctype="multipart/form-data" action="{{ route('message.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>Select Groups:</label>
                                        <!-- <select class="form-control select2" id="user_pos_id" name="user_pos_id[]" multiple="multiple">
                                            <option>Sathish</option>
                                            <option>Rajesh</option>
                                            <option>Jhon</option>
                                            <option>Vicky</option>
                                        </select> -->

                                        <div class="table-responsive">    
                                            
                                                @if($selectMyContactGroupDetail->count()>0)  
                                                    <table id="contact-group-datatable" class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">#</th>
                                                                <th>Group Name</th>
                                                                <th>No of Contacts</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody> 
                                                    @foreach($selectMyContactGroupDetail as $selectMyContactGroupDetailVal)              
                                                        <tr>
                                                            <td><input type="checkbox" name="grp_ids[]" id="grp_ids" value="{{$selectMyContactGroupDetailVal->id}}"></td>
                                                            <td>{{$selectMyContactGroupDetailVal->group_name}}</td>
                                                            <td>{{$selectMyContactGroupDetailVal->grpcontactcount}}</td>

                                                        </tr>

                                                    @endforeach
                                                        </tbody>
                                                    </table>

                                                @else
                                                    <div class="alert alert-danger alert-block">
                                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                                        <h5>Please create the group first.<a href="{{asset('/settings/bulkupload')}}">Click here</a></h5>
                                                    </div>
                                                    
                                                @endif
                                                
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label>From Name/Email:</label>
                                        
                                        <select class="form-control" name="sent_from_user" id="sent_from_user" >
                                            <option value="">--Select--</option>
                                            @foreach($selectUserMasterDetail as $value)
                                            <option value="{{$value->user_id}}">{{$value->first_name}} / {{$value->email}}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label>Subject:</label>
                                        <input type="text" name="camp_subject" id="camp_subject" class="form-control" required placeholder="Subject:"/>
                                    </div>
                                      
                                    <div class="form-group">
                                        <label>Message</label>
                                        <!-- <div> -->
                                            <!-- <div class="camp_message" name="camp_message" id="camp_message" ></div> -->

                                            <textarea name="camp_message" id="camp_message" class="form-control" rows="5"></textarea>
                                        <!-- </div> -->
                                    </div>

                                    <div class="form-group">
                                        <label>Attachments:</label>
                                        <input type="file" class="form-control" multiple="" name="camp_attach[]" id="camp_attach" />
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                Send
                                            </button>
                                            <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                Discard
                                            </button>
                                        </div>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div> <!-- end col -->




            </div> <!-- end row -->

@section('js_script')            
        <link href="{{ URL::asset('css/adminlte.css') }}" rel="stylesheet" type="text/css" />
        <!--Wysiwig js-->
        <script src="{{ URL:: asset('assets/theme/plugins/tinymce/tinymce.min.js')}}"></script>
        
        <!-- Summernote css -->
        <link href="{{ URL::asset('assets/theme/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet" type="text/css" />

        <!--Summernote js-->
        <script src="{{ URL:: asset('assets/theme/plugins/summernote/summernote-bs4.min.js')}}"></script>

        <script>
            jQuery(document).ready(function(){
                $('#camp_message').summernote({
                    height: 300,                 // set editor height
                    minHeight: null,             // set minimum height of editor
                    maxHeight: null,             // set maximum height of editor
                    focus: true                 // set focus to editable area after initializing summernote
                });
            });
        </script>
            <script>
                $(document).ready(function () {
                    // if($("#camp_message").length > 0){
                        tinymce.init({
                            selector: "textarea#camp_message111",
                            theme: "modern",
                            height:300,
                            plugins: [
                                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                                "save table contextmenu directionality emoticons template paste textcolor"
                            ],
                            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                            style_formats: [
                                {title: 'Bold text', inline: 'b'},
                                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                                {title: 'Example 1', inline: 'span', classes: 'example1'},
                                {title: 'Example 2', inline: 'span', classes: 'example2'},
                                {title: 'Table styles'},
                                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                            ]
                        });
                    // }
                });

                $(".select2").select2();
             $(document).ready(function() {

                loadDatatable();
                $("#item_year").datepicker({
                    format: "yyyy",
                    viewMode: "years",
                    minViewMode: "years"
                });


              // $("#eventDateSearch").
            });

                function loadDatatable(){
                    //var date = $('#eventDateSearch').datepicker('getFormattedDate',"yyyy-mm-dd");
                    messagesDatatable = $('#messagesDatatable').DataTable({
                        "serverSide": true,
                        "destroy": true,
                        "autoWidth": false,
                        "searching": true,
                        "aaSorting": [[ 1, "desc" ]],
                        "columnDefs": [
                            {
                                "targets": 0,
                                "searchable": false,
                                "visible" : true
                                }
                            ],
                        "ajax": {
                            type: "POST",
                            data: {},
                            url: siteUrl + '/resource/list',
                        }, //'eventId', 'eventName','eventDesc' , 'eventFreq', 'eventCreatedDate', 'eventCheckin', 'eventStartCheckin', 'eventEndCheckin','eventLocation'
                        columns: [
                            {data: 'image', name: 'item_photo'},
                            {data: 'quantity', name: 'quantity'},
                             {data: 'item_name', name: 'item_name'},
                            {data: 'action', name: 'action', orderable: false, searchable: false},
                        ],
                        "initComplete": function(settings, json) {
                          // $("#eventsTable_filter").append('<button class="btn small btn-primary" id="eventDateSearch"  >Event Date</button>');

                        }
                    });
                }


            function createResourceDialog(){
                 createResourceDlg = BootstrapDialog.show({
                    title:"Create Resource",
                    size:"size-wide",
                    message: $('<div></div>').load(siteUrl+"/resource/create_page"),
                    buttons: [
                        {
                            label: 'Submit',
                            cssClass: 'btn-primary',
                            action: function(dialogRef){
                                submitCreateResource();
                            }
                        },
                        {
                            label: 'Cancel',
                            action: function(dialogRef){
                                dialogRef.close();
                            }
                        }
                    ]
                });
            }

            function submitCreateResource(){

                $('#create_resource_form').ajaxForm(function(data) {
                   $("#create_resource_form_status").html(data.message);
                   setTimeout(function(){
                       createResourceDlg.close();
                        messagesDatatable.draw(false);
                    },2000);
                });

                //$("#create_resource_form").submit();
                $("#formSubmitBtn").click();
            }

            function editResource(resourceId){
                createResourceDlg = BootstrapDialog.show({
                    title:"Update Resource",
                    size:"size-wide",
                    message: $('<div></div>').load(siteUrl+"/resource/edit/"+resourceId),
                    buttons: [
                        {
                            label: 'Submit',
                            cssClass: 'btn-primary',
                            action: function(){
                                submitCreateResource();
                            }
                        },
                        {
                            label: 'Cancel',
                            action: function(dialogRef){
                                dialogRef.close();
                            }
                        }
                    ]
                });
            }


                    </script>
@endsection
@endsection



