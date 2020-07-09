@extends("groups.public.layout.public_layout")

@section("content")

    <!-- @include("groups.public.layout.groups_select_blk") -->

    <div class="row">
      <div class="col-12"> 
    	 @foreach ($group_types as $types)

		    <?php
               $whereArray = array('groupType_id' => $types->id );											   
               $group = \App\Models\Group::getGroupCount($whereArray)->get()[0];
            ?>

		 <div class="card m-b-30 card-body">
			<h4 class="card-title font-20 mt-0">{{ $types->name }}</h4> <p class="text-success"><b>{{ $group->group_count }} groups</b></p>
			<p class="card-text">{{ $types->description }}</p>
			
			<p class="mb-0 m-t-20 text-muted">
	            	<span class="pull-left">
	            		<a href="{{URL::asset($org.'/groups/list')}}/{{ $types->id }}" type="button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-plus"></i>View Groups</a>

	            	</span>

					<?php

						$whereArray = array('groupType_id' => $types->id );
												                       
                        $group = \App\Models\Group::selectFromGroupCondition($whereArray,null,null,null,null,null,null,'1')->get();
                    ?>

                      @foreach ($group as $types)
                        <p class="mb-0 m-t-20 text-muted">
	            	
						@if(isset($types->image_path))
						<?php
							$group_image_json = json_decode(unserialize($types->image_path));
							$profile_pic_image = $group_image_json->original_filename;
						?>

                           @php ($groupImg = $types->orgId.'/group/'.$types->id.'/'.$profile_pic_image)
						
						@else 
						
						   @php ($groupImg = " ")

						@endif
	            	<span class="pull-right">	            		
	            			<img class="d-flex mr-3 rounded-circle" src="{{ URL::asset('assets/uploads/organizations/'.$groupImg)}}" alt="Group image" height="64" />
	            	</span>
                    </p>
				 @endforeach	
            </p>
            

		  </div>
<hr style="border: 1px solid red;">	 
         @endforeach		
       </div>
	</div>


	<!--<div class="row">
      <div class="col-12">    
    	 @foreach ($get_all_group_types as $types)
		 <div class="card m-b-30 card-body">
			<h4 class="card-title font-20 mt-0">{{ $types->group_type_name }}</h4>
			<p class="card-text">{{ $types->group_type_description }}</p>
			
			<p class="mb-0 m-t-20 text-muted">
	            	<span class="pull-left">
	            		<a href="{{URL::asset($org.'/groups/list')}}/{{ $types->id }}" type="button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-plus"></i>View Groups</a>

	            	</span>

					@if(isset($types->group_img))
                      <?php
					      $group_image_json = json_decode(unserialize($types->group_img));
					      $grp_pic_image = $group_image_json->original_filename;
					  ?>

					  @php ($groupImg = $types->orgid.'/group/'.$types->groupid.'/'.$grp_pic_image)
					
					@else 
                     
					  @php ($groupImg = " ")

					@endif
	            	<span class="pull-right">	            		
	            			<img class="d-flex mr-3 rounded-circle" src="{{ URL::asset('assets/uploads/organizations/'.$groupImg)}}" alt="Group image" height="64" />
	            	</span>
            </p>
		  </div>
    <hr style="border: 1px solid red;">	 
         @endforeach		
       </div>
	</div>-->

@endsection