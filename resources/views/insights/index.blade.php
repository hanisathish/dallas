@extends('layouts.default')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item active">Insight Management</li>
                </ol>
            </div>
            <!--<h4 class="page-title">Roles Management</h4>-->
            <!--<a href="{{URL::asset('role_create')}}" type="button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-plus"></i>Add Role</a>-->
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body">

                <h4 class="mt-0 header-title">Insights <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-insight">Add New</button></h4>

                <!-- <button type="button" class="btn btn-primary waves-effect waves-light" id="alertify-labels">Click me</button> -->
                
                <!-- -->
                <table id="insightTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Link/Download</th>
                            <th>Action</th>
                    </thead>

                    <tbody>

                    </tbody>
                </table>


            </div>
        </div>
    </div> <!-- end col -->

</div> <!-- end row -->


<div class="modal fade bs-example-modal-center" id="modal-insight" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    {!! Form::open(array('id'=>'insightCreateForm','name'=>'insightCreateForm','method' => 'post', 'url' => url('insight_data_insert'), 'class' => '')) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title insight_modal_title">Add Insights</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body form-horizontal insightbody">			
			
                <div class="form-group no-bg">
                    <label for="" class="col-sm-10 control-label text_align_right" style="text-align: left !important;">Type</label>
                    <div class="col-sm-9">
                        <input type="hidden" name="hidden_insightID" id="hidden_insightID" value="" />
                        <select id="type" name="type" class="form-control">
							<option value="">Select</option>
							<option value="1">File</option>
							<option value="2">URL Path</option>
					 </select>
                    </div>
                </div>
				
				<div id="dvFile" style="display: none">
					<div class="form-group no-bg">
						<label for="" class="col-sm-10 control-label text_align_right" style="text-align: left !important;">File</label>
						<div class="col-sm-9">                        
							<input class="form-control"  type="file" value="" id="file" name="file" >
						</div>
					</div>
				</div>
				
			  <div id="dvLink" style="display: none">	
				<div class="form-group no-bg">
                    <label for="" class="col-sm-10 control-label text_align_right" style="text-align: left !important;">Link</label>
                    <div class="col-sm-9">
                        <input class="form-control"  type="url" value="" id="source" name="source">
                    </div>
                </div>	
              </div>				
				
				<div class="form-group no-bg">
                    <label for="" class="col-sm-10 control-label text_align_right" style="text-align: left !important;">Name</label>
                    <div class="col-sm-9">
                        <input class="form-control"  type="text" value="" id="name" name="name" >
                    </div>
                </div>
				
				
				<div class="form-group no-bg">
                    <label for="" class="col-sm-10 control-label text_align_right" style="text-align: left !important;">Description</label>
                    <div class="col-sm-9">
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                </div>
				
				
                <button type="button" class="btn btn-success margin pull-left" id="btnCreateInsight">Save</button>
                <button type="button" class="btn btn-danger margin pull-right" data-dismiss="modal">Cancel</button>
                <div class="clear"></div>
            </div>
        </div><!-- /.modal-content -->
    {!! Form::close() !!}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 
<script>

$(function () {
$("#type").change(function () {
	if ($(this).val() == "1") {
		$("#dvFile").show();
	} else {
		$("#dvFile").hide();
	}

	if ($(this).val() == "2") {
		$("#dvLink").show();
	} else {
		$("#dvLink").hide();
	}

});
	
});
 
    $(document).ready(function() {
		
        loadInsightDatatable();
	
	});

    function loadInsightDatatable() {

        insightTable = $('#insightTable').DataTable({
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
                url: siteUrl + '/insights/list',
            },
            "initComplete": function(settings, json) {
                // $("#eventsTable_filter").append('<button class="btn small btn-primary" id="eventDateSearch"  >Event Date</button>');

            }
        });
    }


    $('#modal-insight').on('hidden.bs.modal', function() {
        $(".insight_modal_title").html('');
        $(".insight_modal_title").html('Add Insights');
        $('.insightbody').find('select').val('');
        $('.insightbody').find('input').val('');

        var $alertas = $('#insightCreateForm');
        $alertas.validate().resetForm();
        $alertas.find('.error').removeClass('error');
    });


    $(document).ready(function() {
        chkValidateStatus = "";
        chkValidateStatus = $("#insightCreateForm").validate({
            //ignore:[],// false,
            ignore: false,
            errorClass: "error",
            rules: {
                type: {
                    required: true
                },
                name: {
                    required: true
                }
            },
            messages: {
                type: {
                    required: "Please select Insight Type"
                },
                name: {
                    required: "Please enter name"
                }
            }
        });
    });



    //Save Insight details to the database

    $("#btnCreateInsight").click(function() {
        
		//alert('submit');
		
        var formObj = $('#insightCreateForm');
        var formData = new FormData(formObj[0]);

        $("#insightCreateForm").valid();

        var errorNumbers = chkValidateStatus.numberOfInvalids();
		
        //alert(errorNumbers);
		
        if (errorNumbers == 0) {
            $.ajax({
                url: siteUrl + '/insight_data_insert',
                async: true,
                type: "POST",
                data: formData,
                dataType: "html",
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
					console.log(data);
					
                    $('#modal-insight').modal('hide');
                    if (data == "updated") {
                        //alert("Insight Updated");
                        //location.reload();
                        loadInsightDatatable();

                    } else if (data == "inserted") {
                        //alert("Insight Added");
                        //location.reload();
                        loadInsightDatatable();

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
    $('#insightCreateForm').submit(function(e) {
        var errorNumbers = chkValidateStatus.numberOfInvalids();
        if (errorNumbers == 0) {
            return true;
        } else {

        }
    });

    //Edit the insight data
    function edit_insight(insightID) {
		
        //alert(insightID);
		
        $(".insight_modal_title").html('');
        $(".insight_modal_title").html('Edit Insights');
        var dataString = 'insightID=' + insightID;

        $.ajax({
            url: siteUrl + '/insights/get_insight_by_id',
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
                $('#modal-insight').modal('show');
                $("#hidden_insightID").val(data.id);
                $("#name").val(data.name);
				$("#type").val(data.type);
				$("#source").val(data.source);
                $("#description").val(data.description);
				
				var type = $('#type option:selected').val();					
				if(type =="1")
				{ 
					$("#dvFile").show();
					$("#source").val('');
					
				} else 
				{
					$("#dvFile").hide();
				}

				if(type =="2")
				{ 
					$("#dvLink").show();
										
				} else 
				{
					$("#dvLink").hide();
				}

            }
        });

    }

    
//Delete the insight data
function insight_data_delete(insightId)
{
    
    alertify.confirm("Are you sure you want to delete?", function (asc) {
         if (asc) {
             //ajax call for delete    
             var dataString = 'insightId=' + insightId;

             $.ajax({
                url: siteUrl + '/insights/insight_data_delete',
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
                    loadInsightDatatable();

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