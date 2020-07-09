<div class="col-lg-9">
    <div class="card m-b-30">
        <div class="card-header">

        </div>
        <div class="card-body">
            <div class="col-12">
                <div class="row">
                        <div class="tab-content" id="v-pills-tabContent" style="width: 100%">
                                <button class="btn btn-outline-primary float-right " style="margin-right: 40px" onclick="addResource()">Add Resource</button>


                                <table id="resourceTable" class="table table-bordered" style="table-layout: fixed;">
                                        <thead>
                                            <tr>
                                                <th width=20>TYPE</th>
                                                <th style="max-width: 20%">RESOURCE NAME</th>
                                                <th>DESCRIPTION</th>
                                                <th>LAST UPDATED</th>
                                                <th>VISIBILITY</th>
                                                <th style="width: 20%">ACTION</th>
                                            </tr>
                                        </thead>


                                        <tbody>

                                        </tbody>
                                    </table>
                        </div>

                </div>
            </div>
        </div>

    </div>
</div>
<script>
$(document).ready(function() {

    loadDatatable();



  // $("#eventDateSearch").
});

    function loadDatatable(){
        //var date = $('#eventDateSearch').datepicker('getFormattedDate',"yyyy-mm-dd");
        resourceTable = $('#resourceTable').DataTable({
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
                data: {groupId:<?= $groupId ?>},
                url: siteUrl + '/groups/resources/list',
            }, //'eventId', 'eventName','eventDesc' , 'eventFreq', 'eventCreatedDate', 'eventCheckin', 'eventStartCheckin', 'eventEndCheckin','eventLocation'
            columns: [
                {data: 'type', name: 'type'},
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'visibility', name: 'visibility'},
                {data: 'action', name: 'action', orderable: false, searchable: false},

            ],
            "initComplete": function(settings, json) {
              // $("#eventsTable_filter").append('<button class="btn small btn-primary" id="eventDateSearch"  >Event Date</button>');

            }
        });
    }


function addResource(){
    addResourceDlg = BootstrapDialog.show({
        title:"Add Resource",
        size:"size-wide",
        message: $('<div></div>').load(siteUrl+"/groups/resources/add?groupId=<?= $groupId ?>"),
        buttons: [
            {
                label: 'Submit',
                cssClass: 'btn-primary',
                action: function(dialogRef){
                    submitAddResource();
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

function editResource($resourceId){
    addResourceDlg = BootstrapDialog.show({
        title:"Edit Event",
        size:"size-wide",
        message: $('<div></div>').load(siteUrl+"/groups/resources/edit/"+$resourceId+"?groupId=<?= $groupId ?>"),
        buttons: [
            {
                label: 'Submit',
                cssClass: 'btn-primary',
                action: function(dialogRef){
                    submitAddResource();
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

function submitAddResource(){

$('#create_resources_form').ajaxForm(function(data) {
   $("#create_resources_form_status").html(data.message);
   setTimeout(function(){
    addResourceDlg.close();
    resourceTable.draw(false);
    },2000);
});

//$("#create_resource_form").submit();
$("#formSubmitBtn").click();
}


</script>
