@extends('layouts.default')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item active">Team Management</li>
                </ol>
            </div>
            <!--<h4 class="page-title">Roles Management</h4>-->
            <!--<a href="{{URL::asset('role_create')}}" type="button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-plus"></i>Add Role</a>-->
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->
<link href="{{ URL::asset('assets/select2/select2.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ URL:: asset('assets/select2/select2.js')}}"></script>

<div class="row">
    <div class="col-lg-3">
        <div class="card m-b-30">
            <div class="card-body">
                <div class="button-items">
                    <a href="{{URL::asset('settings/position')}}" class="btn btn-primary btn-lg btn-block">Positions</a>
                    <a href="{{URL::asset('settings/team')}}" class="btn btn-primary btn-lg btn-block">Teams</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="card m-b-30">
            <div class="card-body">

                <h4 class="mt-0 header-title">Teams <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-team">Add New</button></h4>

                <!-- <button type="button" class="btn btn-primary waves-effect waves-light" id="alertify-labels">Click me</button> -->
                
                <!-- -->
                <table id="teamTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Action</th>
                    </thead>


                    <tbody>

                    </tbody>
                </table>


            </div>
        </div>
    </div> <!-- end col -->




</div> <!-- end row -->


<div class="modal fade bs-example-modal-lg show" id="modal-team" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    {!! Form::open(array('id'=>'teamCreateForm','name'=>'teamCreateForm','method' => 'post', 'url' => url('team_data_insert'), 'class' => '')) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title team_modal_title">Add Team</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body form-horizontal teambody">
                <div class="form-group no-bg">
                    <label for="" class="col-sm-10 control-label text_align_right" style="text-align: left !important;">Team Name</label>
                    <div class="col-sm-9">
                        <input type="hidden" name="hidden_teamID" id="hidden_teamID" value="" />
                        <input type="text" class="form-control" id="name" name="name" placeholder="Team Name" maxlength="200">
                    </div>
                    
                </div>
                <div class="form-group no-bg">
                        <div class="col-sm-9">
                            <select class="form-control select2" id="team_pos_id" name="team_pos_id[]" multiple="multiple">
                                <option>--Select--</option>
                                <?php
                                if($selectFromPosition->count() > 0){
                                    foreach ($selectFromPosition as $selectFromPositionvalue) {
                                    ?>
                                        <option value="{{$selectFromPositionvalue->id}}">{{$selectFromPositionvalue->name}}</option>
                                    <?php
                                    }                    
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                <button type="button" class="btn btn-success margin pull-left" id="btnCreateTeam">Save</button>
                <button type="button" class="btn btn-danger margin pull-right" data-dismiss="modal">Cancel</button>
                <div class="clear"></div>
            </div>
        </div><!-- /.modal-content -->
    {!! Form::close() !!}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    $(document).ready(function() {
        $(".select2").select2();
        loadTeamDatatable();
    });

    function loadTeamDatatable() {

        teamTable = $('#teamTable').DataTable({
            "serverSide": true,
            "destroy": true,
            "autoWidth": false,
            "searching": true,
            "aaSorting": [
                [0, "desc"]
            ],
            "columnDefs": [{
                "targets": 0,
                "searchable": false,
                "visible": false
            }],
            "ajax": {
                type: "POST",
                data: {},
                url: siteUrl + '/settings/team/list',
            },
            "initComplete": function(settings, json) {
                // $("#eventsTable_filter").append('<button class="btn small btn-primary" id="eventDateSearch"  >Event Date</button>');

            }
        });
    }





    $('#modal-team').on('hidden.bs.modal', function() { 
        $(".team_modal_title").html('');
        $(".team_modal_title").html('Add Team');
        $('.teambody').find('select').val('');
        $('.teambody').find('input').val('');


        $("#team_pos_id").val('').trigger('change')

        var $alertas = $('#teamCreateForm');
        $alertas.validate().resetForm();
        $alertas.find('.error').removeClass('error');

        
    });


    $(document).ready(function() {


        chkValidateStatus = "";
        chkValidateStatus = $("#teamCreateForm").validate({
            //ignore:[],// false,
            ignore: false,
            errorClass: "error",
            rules: {
                name: {
                    required: true
                }

            },
            messages: {
                name: {
                    required: "Please select team name"
                }
            }
        });

    });



    //Save Team details to the database

    $("#btnCreateTeam").click(function() {
        
        var formObj = $('#teamCreateForm');
        var formData = new FormData(formObj[0]);

        $("#teamCreateForm").valid();

        var errorNumbers = chkValidateStatus.numberOfInvalids();
        
        if (errorNumbers == 0) {
            $.ajax({
                url: siteUrl + '/team_data_insert',
                async: true,
                type: "POST",
                data: formData,
                dataType: "html",
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#modal-team').modal('hide');
                    if (data == "updated") {
                        //alert("Team Updated");
                        //location.reload();
                        loadTeamDatatable();

                    } else if (data == "inserted") {
                        //alert("Team Added");
                        //location.reload();
                        loadTeamDatatable();

                    } else {
                        alert("Error in Updation");
                        return false;
                    }
                }

            });

        } else {

        }
    });

    //form submission
    $('#teamCreateForm').submit(function(e) {
        var errorNumbers = chkValidateStatus.numberOfInvalids();
        if (errorNumbers == 0) {
            return true;
        } else {

        }
    });

    //Edit the Teams data
    function edit_team(teamID) {
        $(".team_modal_title").html('');
        $(".team_modal_title").html('Edit Team');
        var dataString = 'teamID=' + teamID;

        $.ajax({
            url: siteUrl + '/settings/get_team_by_id',
            async: true,
            type: "GET",
            data: dataString,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                //console.log(data);
                //location.reload();
                $('#modal-team').modal('show');
                $("#hidden_teamID").val(data.teamData.id);
                $("#name").val(data.teamData.name);
                
                var loadPos = data.teamPos;
                var posArray = loadPos.split(',');

                $(".select2").val(posArray).change();
                //setTimeout(function(){  }, 3000);

                

            }
        });

    }

    
//Delete the team data
function team_data_delete(teamId)
{
    
    alertify.confirm("Are you sure you want to delete?", function (asc) {
         if (asc) {
             //ajax call for delete    
             var dataString = 'teamId=' + teamId;

             $.ajax({
                url: siteUrl + '/settings/team_data_delete',
                async: true,
                type: "GET",
                data: dataString,
                dataType: "html",
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    //location.reload();
                    loadTeamDatatable();

                }
            });   
             alertify.success("Record is deleted.");

         } else {
             alertify.error("You've clicked cancel");
         }
     },"Default Value");
    /*

    , 
     // theme settings
     theme:{
            // class name attached to prompt dialog input textbox.
            input:'ajs-input',
            // class name attached to ok button
            ok:'ajs-ok',
            // class name attached to cancel button 
            cancel:'ajs-cancel'
        }


    var dataString = 'teamId=' + teamId;

    bootbox.confirm({
        title: "Confirm",
        message: "<h4 id='modal_content'>Do you want to continue to delete this Team?</h4>",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> No',
                className: 'btn-danger'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Confirm',
                className: 'btn-success'
            }
        },
        callback: function (result) {
            if (result === true) {
                $.ajax({
                    url: siteUrl + '/team_data_delete',
                    async: true,
                    type: "GET",
                    data: dataString,
                    dataType: "html",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data)
                    {
                        //location.reload();
                        loadTeamDatatable();

                    }
                })
            }
            else
            {

            }
        }
    });
    */
 }


</script>

@endsection