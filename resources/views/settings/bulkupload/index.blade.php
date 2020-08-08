@extends('layouts.default')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item active">Bulk Upload Management</li>
                </ol>
            </div>            
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">

                <h4 class="mt-0 header-title">Bulk Upload Management</h4>
                @if ($errors->any())

                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <ul style="list-style: none;padding: 0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>

                @endif

                @if($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                </div>
                @endif

                @if($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                </div>
                @endif

                <form method="post" enctype="multipart/form-data" action="{{ route('bulk_import_excel.store') }}">
                @csrf
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Select Upload Type</label>
                    <div class="col-sm-3">
                        <select name="bulk_upload_type" id="bulk_upload_type" class="form-control"  onchange="javascript:show_upload_sample_file(this)" >
                            <option value="">--Select--</option>
                            <option value="contact_bulk">Contact Upload</option>
                            
                        </select>
                    </div>
                    <div class="col-sm-3" >
                        <span class="bulk_upload_type_class member_bulk_file"></span>
                        <span class="bulk_upload_type_class contact_bulk_file">
                            <a class="btn btn-outline-info waves-effect waves-light" href="{{asset('assets/uploads/bulk_upload_sample/bulk_contact_sample.xls')}}"><i class="fa fa-download"></i> Download Sample File</a>
                        </span>                        
                    </div>
                    
                </div> 

                
                <div class="form-group row contact_bulk_div">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Select Group Name</label>
                    <div class="col-sm-3">
                        <select id="group_id" required="" name="group_id" class="form-control" onchange="javascript:changeGroup(this);">
                            <option value=""> -- Select -- </option>
                            <option value="new"> Enter New Group Name </option>
                            @if($crudMyContactGroup->count() > 0)
                                @foreach($crudMyContactGroup as $crudMyContactGroupValue)
                                    <option value="{{$crudMyContactGroupValue->id}}">{{$crudMyContactGroupValue->group_name}}</option>                                
                                @endforeach
                            
                            @else
                            
                            @endif
                        </select>    
                    </div>
                    <div class="col-sm-3 grpname" >
                        <input type="text" name="grp_name_enter" id="grp_name_enter" class="form-control" placeholder="Enter Group Name"/>
                    </div>
                </div>     
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Select File for Upload</label>
                    <div class="col-sm-3">
                        <input type="file" name="import_file" id="import_file" class="form-control" required/>                        
                    </div>
                    
                </div> 
                <div class="form-group row">
                    <div class="col-sm-3">
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-md btn-success" id="bulkUpload"><i class="fa fa-upload"></i> Upload</button>
                    </div>
                </div> 
                
                </form>
                 
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<div class="clearfix"></div>


    @section('js_script')
        <script>
            $(function () {
                $('.bulk_upload_type_class').hide();
                $('.contact_bulk_div').hide();
                $('.grpname').hide();
            });
            function show_upload_sample_file(obj){
                var bulk_upload_type = obj.value;
                if(bulk_upload_type){
                    $('.contact_bulk_div').show();
                    $('.bulk_upload_type_class').hide();
                    $('.contact_bulk_file').show();
                }else{
                    $('.bulk_upload_type_class').hide();
                    $('.contact_bulk_div').hide();
                }
            }

            function changeGroup(obj){
                var group_name = obj.value;
                if(group_name == 'new'){
                    $('.grpname').show();
                    $("#grp_name_enter").val('');
                }else{
                    $('.grpname').hide();
                    $("#grp_name_enter").val('');
                }
            }
        </script>

    @endsection    
@endsection