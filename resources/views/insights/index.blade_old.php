@extends('layouts.default')

@section('content')
    <div style="width:100vw">
        <!-- @include('givings.header') -->
        <div class="row m-5 pl-4 pr-4">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <!-- <h5 class="mt-0">Giving List<a href="{{ URL:: asset('settings/givings/manage/')}}" class="btn btn-sm btn-success pull-right text-white"><i class="fa fa-plus"></i> Create New</a></h5> -->
                        <button class="btn btn-outline-primary float-right " style="margin-right: 40px" onclick="addInsights()">Add Insights</button>
                        <hr/>
                        <div class="tab-content">
                            <div class="tab-pane active p-3">
                                <table id="insightsDatatable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width=20>TYPE</th>
                                                <th style="max-width: 20%">INSIGHTS NAME</th>
                                                <th>DESCRIPTION</th>
                                                <th>LAST UPDATED</th>
                                                <!--<th>TYPE</th>-->
                                                <th style="width: 20%">ACTION</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
<script>
    $(document).ready(function () {
//    $(".container-fluid").addClass("m-0 p-0");
    $(".container-fluid").css({ width: "100vw" });
    $(".wrapper").css("padding-top", "118px");
    loadInsightsDatatable();
});

function loadInsightsDatatable() {
    let dt = $('#insightsDatatable').DataTable({
        "serverSide": true,
        "destroy": true,
        "autoWidth": false,
        "searching": true,
        "aaSorting": [[1, "desc"]],
        "nowrap": true,
        "ajax": {
            type: "GET",
            url: siteUrl + `/insights/list`,
        },
        "columnDefs": []
    });
    // dt.on('order search', function () {
    //     dt.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
    //         cell.innerHTML = i + 1;
    //     });
    // }).draw();
}


function addInsights(){
    addInsightsDlg = BootstrapDialog.show({
        title:"Add Insights",
        size:"size-wide",
        message: $('<div></div>').load(siteUrl+"/insights/add?groupId=<?= 0 ?>"),
        buttons: [
            {
                label: 'Submit',
                cssClass: 'btn-primary',
                action: function(dialogRef){
                    submitaddInsights();
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

function editInsights($resourceId){
    addInsightsDlg = BootstrapDialog.show({
        title:"Edit Insights",
        size:"size-wide",
        message: $('<div></div>').load(siteUrl+"/insights/edit/"+$resourceId+"?groupId=<?= 0 ?>"),
        buttons: [
            {
                label: 'Submit',
                cssClass: 'btn-primary',
                action: function(dialogRef){
                    submitaddInsights();
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

function submitaddInsights(){

$('#create_resources_form').ajaxForm(function(data) {
   $("#create_resources_form_status").html(data.message);
   setTimeout(function(){
    addInsightsDlg.close();
    //insightsDatatable.draw(false);
    loadInsightsDatatable();
    },2000);
});

//$("#create_resource_form").submit();
$("#formSubmitBtn").click();
}
</script>

@endsection