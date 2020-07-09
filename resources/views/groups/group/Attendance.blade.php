<div class="col-lg-9">
    <div class="card m-b-30">
        <div class="card-header">
            Attendance Information
        </div>
        <div class="card-body">
            <div class="col-12">
                <div class="row">
                        <div class="tab-content" id="v-pills-tabContent" style="width: 100%">
                            <div class="row">
                                    <div class="col-md-5 form-row" style="align-items: center;">

                                        <lable class="col-md-3">From Date:</lable>
                                         <input class="form-control col-md-8" required="" type="text" value="{{date('01-m-Y')}}" id="start_date" name="start_date">
                                    </div>
                                    <div class="col-md-5 form-row" style="align-items: center;">
                                            <lable class="col-md-3">To Date:</lable>
                                             <input class="form-control col-md-8" required="" type="text" value="{{date('d-m-Y')}}"  id="end_date" name="start_date">
                                        </div>
                                        <div class="col-md-2 form-row" style="align-items: center;">
                                                <button class="btn btn-primary "  style="margin-right: 40px" onclick="searchAttedence()">Search</button>
                                        </div>
                            </div>



                            <table id="attendenceTable" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>First</th>
                                        <th>Last</th>
                                        <th>%</th>
                                        @foreach($attendance as $value)
                                            <th>{{$value->event_date}}</th>
                                        @endforeach
                                    </thead>


                                    <tbody>

                                    </tbody>
                                </table></div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function() {


        $('#start_date').datepicker({
        format: 'dd-mm-yyyy',
        //startDate: '-3d'
    });
    $('#end_date').datepicker({
        format: 'dd-mm-yyyy',
        //startDate: '-3d'
    });
        var events =('<?= json_encode($attendance->toArray()) ?>');
        var  columns=  [
                    {data: 'first_name', name: 'first_name'},
                    {data: 'last_name', name: 'last_name'},
                     {data: 'percentage', name: 'percentage'},
                     @foreach($attendance as $value)
                        {data: '{{str_replace(" ","_",$value->event_date)}}', name: '{{$value->id}}', orderable: false, searchable: false},
                     @endforeach

                ];
        loadDatatable(events,columns);



      // $("#eventDateSearch").
    });

        function loadDatatable(events,columns){
            //var date = $('#eventDateSearch').datepicker('getFormattedDate',"yyyy-mm-dd");

            membersTable = $('#attendenceTable').DataTable({
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
                    data: {groupId:<?= $groupId ?>,events:events},
                    url: siteUrl + '/groups/attedence/list',
                }, //'eventId', 'eventName','eventDesc' , 'eventFreq', 'eventCreatedDate', 'eventCheckin', 'eventStartCheckin', 'eventEndCheckin','eventLocation'
                columns: columns,
                "initComplete": function(settings, json) {
                  // $("#eventsTable_filter").append('<button class="btn small btn-primary" id="eventDateSearch"  >Event Date</button>');

                }
            });
        }

        function searchAttedence(){
            var start_date = $("#start_date").datepicker("getFormattedDate");
            var end_date =$("#end_date").datepicker("getFormattedDate");

            $.post( siteUrl + '/groups/attedence/get_event_dates', { group_id:<?= $groupId ?>,start_date: start_date, end_date:end_date })
            .done(function( data ) {

                var  columns=  [
                    {data: 'first_name', name: 'first_name'},
                    {data: 'last_name', name: 'last_name'},
                     {data: 'percentage', name: 'percentage'}


                ];
                $("#attendenceTable thead th:gt(2)").remove();

                membersTable.destroy();
                $("#attendenceTable tbody").empty();
                $.each(data.events, function( key, value ) {
                    let da = (value.event_date);
                    da = da.replace(" ","_");
                    //alert( index + ": " + value );
                    columns.push({data:da,name:da,orderable: false, searchable: false});
                    $("#attendenceTable thead tr").append("<th>"+value.event_date+"</th>");
                });
                setTimeout(function(){
                    loadDatatable(JSON.stringify(data.events),columns);
                },200)

               // alert( "Data Loaded: " + data );
            });
        }
        </script>
