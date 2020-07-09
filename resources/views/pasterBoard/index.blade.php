@extends('layouts.default')

@section('content')
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group pull-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item active">Post Management</li>
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
                                    <a href="{{URL::asset('pastor_board/manage')}}" class="btn btn-primary btn-lg btn-block">Manage Board</a>

                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row">

                            <div class="col-md-5" style="padding-bottom: 10px">
                                <input type="search" class="form-control" id="search_txt" autocomplete="off">
                                <input type="hidden" name="search_str" id="search_str" />
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" onclick="searchPost()">Search</button>

                            </div>
                        </div>
                                <!-- -->
                                <div class="row" id="postList">





                                </div>


                        </div>
                    </div> <!-- end col -->




            </div> <!-- end row -->

            <script>

             $(document).ready(function() {

                //loadDatatable();

                loadPost(0);

              // $("#eventDateSearch").
            });
            function searchPost(){
                var search = $("#search_txt").val();
                search =  $.trim(search);
                if(search !="") {
                    $('#postList').html("");
                    $("#search_str").val($("#search_txt").val());
                    loadPost(0);
                }

            }
            function loadPost(offset){
                var search = $("#search_str").val();
                search =  $.trim(search);
                $.ajax({
                            type:'POST',
                            url: siteUrl + '/pastor_board/postList',
                            data:{offset:offset,search:search},
                            beforeSend:function(){
                                $('.load-more').show();
                            },
                            success:function(res){
                                $('.load-more').remove();
                                $('#postList').append(res.data).attr("data-count",res.count);
                            }
                        });
            }

            $(document).ready(function(){
                $(window).scroll(function(){
                    var lastID = $("#postList .post-section").length;
                    var total = $("#postList").attr("data-count");

                    console.log(lastID,total);
                    if(($(window).scrollTop() == $(document).height() - $(window).height()) && (lastID != 0)){
                        if(lastID <= total) {
                            loadPost(lastID);
                        }

                    }
                });
            });

                function loadDatatable(){
                    //var date = $('#eventDateSearch').datepicker('getFormattedDate',"yyyy-mm-dd");
                    pastorTable = $('#pastorTable').DataTable({
                        "serverSide": true,
                        "destroy": true,
                        limit:8,
                        "autoWidth": false,
                        "searching": false,
                        "scrollY":        800,
                        "deferRender":    true,
                        //"scroller":       true,
                        scroller: {
                            loadingIndicator: true
                        },
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
                            url: siteUrl + '/pastor_board/postList',
                        }, //'eventId', 'eventName','eventDesc' , 'eventFreq', 'eventCreatedDate', 'eventCheckin', 'eventStartCheckin', 'eventEndCheckin','eventLocation'
                        columns: [

                            {data: 'action', name: 'action', orderable: false, searchable: false},
                        ],
                        "initComplete": function(settings, json) {
                          // $("#eventsTable_filter").append('<button class="btn small btn-primary" id="eventDateSearch"  >Event Date</button>');

                        }
                    });
                }





                    </script>

@endsection



