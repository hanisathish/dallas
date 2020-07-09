@extends('layouts.default')

@section('content')
    <!-- <div style="width:100vw"> -->
        @include('settings.organization.header')
        <div class="row m-5 pl-4 pr-4">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h5 class="mt-0">Organization List<a href="{{ URL:: asset('settings/organization/manage/')}}" class="btn btn-sm btn-success pull-right text-white"><i class="fa fa-plus"></i> Create New</a></h5>
                        <hr/>
                        <div class="tab-content">
                            <div class="tab-pane active p-3">
                                <table id="scheduleDatatable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>				
 											<th>Organization Name</th>
											<th>Organization Domain</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- </div> -->
    
    


@endsection

@section('js_script')
<script src="{{ URL:: asset('js/settings/organization/index.js')}}"></script>
        
<script>
    //Delete the data
function organization_data_delete(orgId)
{   

    alertify.confirm("Are you sure you want to delete?", function (asc) {
         if (asc) {
             //ajax call for delete    
             var dataString = 'orgId=' + orgId;
             $.ajax({
                url: siteUrl + '/settings/organization_data_delete',
                async: true,
                type: "GET",
                data: dataString,
                dataType: "html",
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    location.reload();
                }
            });   
             alertify.success("Record is deleted.");

         } else {
             alertify.error("You've clicked cancel");
         }
     },"Default Value");
}
</script>
@endsection