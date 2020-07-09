<div class="col-lg-9">
    <div class="card m-b-30">
        <div class="card-header">
            Events Information
        </div>
        <div class="card-body">
            <div class="col-12">
                <div class="row">
                        <div class="tab-content" id="v-pills-tabContent" style="width: 100%">
                                <button class="btn btn-outline-primary float-right " style="margin-right: 40px" onclick="addEvent()">Add Event</button>


                                <table id="eventTable" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Start</th>
                                            <th>End</th>
                                            <th>Action</th>
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
        eventsTable = $('#eventTable').DataTable({
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
                url: siteUrl + '/groups/events/list',
            }, //'eventId', 'eventName','eventDesc' , 'eventFreq', 'eventCreatedDate', 'eventCheckin', 'eventStartCheckin', 'eventEndCheckin','eventLocation'
            columns: [
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description'},
                {data: 'start', name: 'start_date'},
                {data: 'end', name: 'end_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false},

            ],
            "initComplete": function(settings, json) {
              // $("#eventsTable_filter").append('<button class="btn small btn-primary" id="eventDateSearch"  >Event Date</button>');

            }
        });
    }


function addEvent(){
    addEventDlg = BootstrapDialog.show({
        title:"Add Event",
        size:"size-wide",
        message: $('<div></div>').load(siteUrl+"/groups/events/add?groupId=<?= $groupId ?>"),
        buttons: [
            {
                label: 'Submit',
                cssClass: 'btn-primary',
                action: function(dialogRef){
                    submitAddEvent();
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

function editEvent($eventId){
    addEventDlg = BootstrapDialog.show({
        title:"Edit Event",
        size:"size-wide",
        message: $('<div></div>').load(siteUrl+"/groups/events/edit/"+$eventId+"?groupId=<?= $groupId ?>"),
        buttons: [
            {
                label: 'Submit',
                cssClass: 'btn-primary',
                action: function(dialogRef){
                    submitAddEvent();
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

function submitAddEvent(){

$('#create_event_form').ajaxForm(function(data) {
   $("#create_event_form_status").html(data.message);
   setTimeout(function(){
    addEventDlg.close();
    eventsTable.draw(false);
    },2000);
});

//$("#create_resource_form").submit();
$("#formSubmitBtn").click();
}

function markAttedence($eventId)
{
    markAttedenceDlg = BootstrapDialog.show({
        title:"Mark Attedence",
        size:"size-wide",
        message: $('<div></div>').load(siteUrl+"/groups/events/mark-attendence/"+$eventId+"?groupId=<?= $groupId ?>"),
        buttons: [
            {
                label: 'Submit',
                cssClass: 'btn-primary',
                action: function(dialogRef){
                    submitMarkAttedence();
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
function submitMarkAttedence() {
    $att = [];
    var event_id = "";
    $(".m_check:checked").each(function(){
        $att.push($(this).data("group-member-id"));
        event_id =$(this).data("event");
    });
    if($att.length > 0) {
        console.log(event_id,$att);

        $.post( siteUrl + '/groups/events/submit-attendence', { group_id:<?= $groupId ?>,event_id: event_id, attedence:$att })
            .done(function( data ) {
                $("#attedence_result").html("Saved!").show();
                setTimeout(function(){
                    markAttedenceDlg.close();
                },2000)
            });

    }

}
</script>
