@extends("groups.public.layout.public_layout")

@section("content")
    
			
    <div class="row">
	    @foreach ($list_all_group_types as $types)
      <div class="col-md-6 col-xl-3">
    	
		 <div class="card m-b-30 card-body">
			<h4 class="card-title font-20 mt-0">{{ $types->name }}</h4>
			<p class="card-text">{{ $types->description }}</p>
           
			<p class="card-text">
			        @if(isset($types->image_path))
                      <?php
					      $group_image_json = json_decode(unserialize($types->image_path));
					      $profile_pic_image = $group_image_json->original_filename;
					  ?>

					    @php ($groupImg = $types->orgId.'/group/'.$types->id.'/'.$profile_pic_image)
					
					  @else 
                     
					    @php ($groupImg = " ")

					  @endif
	            	<span class="pull-left">	            		
	            			<img class="d-flex mr-3 rounded-square" src="{{ URL::asset('assets/uploads/organizations/'.$groupImg)}}" alt="Group image" height="70" />
	            	</span></p>

			<p class="card-text">
			    <small class="text-muted"><a href="{{URL::asset($org.'/groups/list')}}/{{ $types->id }}/{{$types->name}}" type="button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-plus"></i>View Group</a></small>				
			</p>
		</div>	
            
       </div>
	   @endforeach
	</div>
					
@endsection