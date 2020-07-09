
@extends("groups.public.layout.public_layout")

@section("content")
   
    <div class="row">
    <div class="col-12">
    <div class="card m-b-30">
        <div class="card-body">
            <div class="media m-b-30">
                
                <div class="media-body">    
                    <h3 class="mt-0 font-18">{{ $get_all_group_details->name }}</h3>
                    <p>{{ $get_all_group_details->description  }}</p> 
                    <p class="card-text">
			        @if(isset($get_all_group_details->image_path))
                      <?php
					      $group_image_json = json_decode(unserialize($get_all_group_details->image_path));
					      $profile_pic_image = $group_image_json->original_filename;
					  ?>

					    @php ($groupImg = $get_all_group_details->orgId.'/group/'.$get_all_group_details->id.'/'.$profile_pic_image)
					
					  @else 
                     
					    @php ($groupImg = " ")

					  @endif
	            	<span class="pull-left">	            		
	            			<img class="d-flex mr-3 rounded-square" src="{{ URL::asset('assets/uploads/organizations/'.$groupImg)}}" alt="Group image" height="100" />
	            	</span>
                    </p>                   
                </div>
                
                     
            </div>
        </div>
    </div>
    </div>
    </div>

    <div class="container mt-3">
        <div class="row">
            <div class="col-lg-6">
            <input class="form-control" type="hidden" value="<?php echo $group_id ?>" id="group_id" name="group_id">
            <input class="form-control" type="hidden" value="<?php echo $get_all_group_details->orgId ?>" id="orgId" name="orgId">
            <div class="demo-content">This group is open to new members.</div>
            </div>
            <div class="col-lg-6">
                <div class="demo-content bg-alt"><button type="button" onclick="createGroupJoinDialog()" class="btn btn-primary waves-effect waves-light">Join this group</button></div>
            </div>
         </div>
   </div>	
   
	<hr>

        <div class="row">
            <div class="col-xs-12">
                <div class="demo-content"><h4>Upcoming events</h4></div>
            </div>
        </div>        
        
        <div class="row">
           @if(count($list_all_group_events) > 0) 
            <div class="col-xs-12">
                @foreach ($list_all_group_events as $events)
                <div class="demo-content bg-alt">{{ $events->title }}</div>
                @endforeach
            </div>
            @else 
            <div class="col-xs-12">
                <div class="demo-content bg-alt">There are no events currently scheduled.</div>
            </div>            
            @endif
        </div>

        
        <!--<div class="row">
            <div class="col-xs-12">
               <div class="demo-content"><h5>Questions?</h5></div>
               <div class="demo-content">Send an email to the contact person for the group.</div>
               <div class="demo-content bg-alt"><button type="button" onclick="contactFormGroupDialog()" class="btn btn-primary waves-effect waves-light">Contact</button></div>
            </div>           
        </div>-->
     	
					
@endsection

<script>

    var siteUrl = '<?php echo url('/'); ?>';

    function createGroupJoinDialog(){ 
            //alert($('#group_id').val());       
            var groupid = $('#group_id').val();
            var orgId = $('#orgId').val();
            //alert(groupid);
            groupJoinDlg = BootstrapDialog.show({
            title:"Join Group",
            size:"size-wide",
            message: $('<div></div>').load(siteUrl+"/groups/join_group?groupid="+groupid+"&orgId="+orgId),
            buttons: [
                {
                    label: 'Submit',
                    cssClass: 'btn-primary',
                    action: function(dialogRef){
                        submitJoinGroup();
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


    function submitJoinGroup(){

        $('#create_join_group').ajaxForm(function(data) {
        $("#create_join_group_status").html(data.message);
        setTimeout(function(){
            groupJoinDlg.close();
            },3000);
        });

        $("#formSubmitBtn").click();
    }

</script>