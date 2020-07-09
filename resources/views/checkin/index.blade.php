@extends('layouts.default')

@section('content')
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group pull-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item active">Checkin</li>
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
                            <div class="card-body">
                                <div class="button-items">
                                    <a style="display: none" href="{{URL::asset('checkin/adult')}}" class="btn btn-primary btn-lg btn-block">Adult Checkin</a>
                                    <a style="display: none" href="{{URL::asset('checkin/child')}}" class="btn btn-primary btn-lg btn-block">Child Checkin</a>
                                    <a href="{{URL::asset('checkin/notification')}}" class="btn btn-primary btn-lg btn-block">Notification</a>
                                    <a href="{{URL::asset('checkin/report')}}" class="btn btn-primary btn-sm btn-block">Report</a>
                                </div>
                            </div>
                        </div>
                    </div>
            <div class="col-lg-9">
                        <div class="card m-b-30">
                            <div class="card-body">

							@if(isset($eventDetails))

                                <div class="card m-b-30 card-body event-details">
                                    <div class="col-md-12">{{$eventDetails->eventName}}</div>
                                    <div class="col-md-12">&nbsp;</div>
                                    <div class="col-md-12">{{date("M d, Y",strtotime($eventDetails->eventCreatedDate))}}</div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="checkInUser" autocomplete="new-password" />
                                        <input type="hidden" class="form-control" id="selectedCheckInUser" />
                                    </div>
                                     <div class="col-md-4">
                                         <button class="btn btn-primary" onclick="checkIn({{$eventDetails->eventId}})"  >Add Check-in</button>
                                         <input type="hidden" id="eventId" value="{{$eventDetails->eventId}}" />
                                     </div>

                                </div>
				@endif
                                <br/>
                                    <div class="row">
                                         <div class="col-md-12">
                                                <table id="checkinsTable" class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>&nbsp;</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                         </div>
                                    </div>
                            </div>
                        </div>
                    </div> <!-- end col -->




            </div> <!-- end row -->

			<script>
				$( function() {
                                    var eventId = <?= $eventDetails->eventId ?>;



                                   $('#checkInUser').autoComplete({
					resolver: 'custom',
                                        minLength:1,
					events: {
						search: function (qry, callback) {
                                                    $("#selectedCheckInUser").val("");
							// let's do a custom ajax call
							$.ajax(
								siteUrl+"/people/list",
								{
									data: { 'phrase': qry,eventId:eventId},
                                                                        method : "POST"
								}

							).done(function (res) {
								callback(res)
							});
						},

					},

				});
                                $('#checkInUser').on('autocomplete.select', function(evt, item) {

                                        $("#selectedCheckInUser").val(item.id);
					//console.log('eventsAutoComplete autocomplete.select');
					//eventsCodeContainer.text(eventsCodeContainer.text() + 'fired autocomplete.select. item: ' + item + ' value: ' + $(this).val() + '\n');
				});

                                   /*console.log(eventId);
					   var options = {

					  url: function(phrase) {
						return siteUrl+"/people/list"
					  },

					  getValue: function(element) {
						return element.name;
					  },

					  ajaxSettings: {
						dataType: "json",
						method: "POST",
						data: {
						  dataType: "json",
                                                  eventId:eventId
						}
					  },

					  list: {
						onClickEvent: function() {

							var userId = $("#checkInUser").getSelectedItemData().userId;

                                                        $("#selectedCheckInUser").val(userId);
							//checkIn(userId);
						},
                                                onLoadEvent:function(){
                                                    $('*[data-user-disabled="true"]').closest("li").addClass("disabled");
                                                }

					},
                                        template: {
                                            type: "custom",
                                            method: function(value, item) {
                                                    return "<span data-user-disabled='" + item.disabled + "'></span>" + value;
                                            }
                                    },

					  preparePostData: function(data) {
						data.phrase = $("#checkInUser").val();
						return data;
					  },

					  requestDelay: 400
					};

					$("#checkInUser").easyAutocomplete(options);*/


                                        //datatable
                                        var eventId = $("#eventId").val();
                                        checkinsTable = $('#checkinsTable').DataTable({
                                            "serverSide": true,
                                            "destroy": true,
                                            "autoWidth": false,
                                            "searching": true,
                                            //"aaSorting": [[ 1, "desc" ]],
                                            "columnDefs": [
                                                {
                                                    "targets": 0,
                                                    "searchable": false,
                                                    "visible" : true
                                                    }
                                                ],
                                            "ajax": {
                                                type: "POST",
                                                data: {eventId:eventId},
                                                url: siteUrl + '/checkin/list',
                                            }, //'eventId', 'eventName','eventDesc' , 'eventFreq', 'eventCreatedDate', 'eventCheckin', 'eventStartCheckin', 'eventEndCheckin','eventLocation'
                                            columns: [
                                                {data: 'checkInUser', name: ''},

                                                //{data: 'action', name: 'action', orderable: false, searchable: false},
                                            ]
                                        });

  } );


  function checkIn(eventId){
      var userId = $("#selectedCheckInUser").val();
      if(userId > 0 ) {
            $.ajax({
              type: "POST",
              url: siteUrl+"/checkin/log-checkin",
              data: {eventId:eventId,userId:userId},
              cache: false,
              success: function(data){
                 checkinsTable.draw(false);
                 $("#selectedCheckInUser").val("")
              }
            });
        }


  }

  function checkOutUser(chId,eventId,userId){
      $.ajax({
        type: "POST",
        url: siteUrl+"/checkin/log-checkout",
        data: {eventId:eventId,userId:userId,chId:chId},
        cache: false,
        success: function(data){
           checkinsTable.draw(false);
        }
      });
  }

  function printCard(eventId,userId,checkinId) {
      /*$.ajax({
        type: "POST",
        url: siteUrl+"/checkin/get-child-profile",
        data: {eventId:eventId,userId:userId,checkinId:checkinId},
        cache: false,
        success: function(data){
           //checkinsTable.draw(false);
        }
      });*/

      profileCardDlg = BootstrapDialog.show({
                    title:"Profile",
                    //size:"size-wide",
                    message: $('<div></div>').load(siteUrl+"/checkins/printChildProfile?eventId="+eventId+"&userId="+userId+"&checkinId="+checkinId),
                    buttons: [
                        {
                            label: 'Print',
                            cssClass: 'btn-primary',
                            action: function(dialogRef){



                                var divToPrint=document.getElementById('profileBlockPrint');

                                var newWin=window.open('','Print-Window');

                                newWin.document.open();

                                newWin.document.write('<html><head><title>print</title></head><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

                                newWin.document.close();

                                setTimeout(function(){newWin.close();},10)
                                //submitCreateEvent();
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



