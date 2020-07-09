<form method="post" action="{{ route('pastor_board.store') }}" name="create_post_form" id="create_post_form" enctype="multipart/form-data">
 <div id="create_post_form_status"></div>
    <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30" style="margin-bottom: 0">
                            <div class="card-body">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}">


                                 <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Title</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" required="" type="text" value="{{ isset($post)?$post->p_title:'' }}" id="p_title" name="p_title" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="p_description" name="p_description">{{ isset($post)?$post->p_description:'' }}</textarea>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Type</label>
                                    <div class="col-sm-9">
                                            <select id="parent_type" name="parent_type" class="form-control" required="" value="{{ isset($post)?$post->parent_type:'' }}" onchange="postType(this.value)">
                                                  <option value="">-- Select -- </option>
                                                <option value="1" <?= isset($post)?($post->parent_type=='1')?'selected':'':'' ?>>Post</option>
                                                    <option value="2" <?= isset($post)?($post->parent_type=='2')?'selected':'':'' ?>>News</option>
                                                    <option value="3" <?= isset($post)?($post->parent_type=='3')?'selected':'':'' ?>>Ads</option>
                                                </select>

                                    </div>
                                    @if(isset($post))
                                    <script>
                                        postType({{$post->parent_type}});
                                    </script>
                                    @endif
                                </div>

                                <div class="form-group row post-ad">
                                        <label for="example-date-input" class="col-sm-3 col-form-label">High Level Categories</label>
                                        <div class="col-sm-4">
                                            <label class="radio-inline"><input type="radio" name="classified_type" value="1"  <?= isset($post)?($post->classified_type=='1')?'checked':'':'' ?>>Sell</label>




                                            <label class="radio-inline" style="margin-left: 20px"><input type="radio" name="classified_type"  value="2" <?= isset($post)?($post->classified_type=='2')?'checked':'':'' ?>>Buy</label>

                                        </div>
                                    </div>

                                    <div class="form-group row post-ad">
                                            <label for="example-date-input" class="col-sm-3 col-form-label">Category</label>
                                            <div class="col-sm-9">
                                                <select id="p_category" name="p_category" class="form-control">
                                                    <option value="">-- Select --</option>
                                                    @foreach($p_category as $value)
                                                        <option value="{{$value->mldId}}" @if(isset($post) &&  $post->p_category == $value->mldId) selected @endif>{{$value->mldValue}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                    </div>
                                    <!--
                                    <div class="form-group row" style="">
                                            <label for="example-date-input" class="col-sm-3 col-form-label">Posted Date</label>
                                            <div class="col-sm-9">
                                                <input class="form-control"  type="text" value="{{ isset($post)?$post->posted_date:'' }}" id="posted_date" name="posted_date" />

                                            </div>
                                    </div>
                                -->


                                 <div class="form-group row">
                                        <label for="example-date-input" class="col-sm-12 col-form-label">Contact Details</label>
                                        <label for="example-date-input" class="col-sm-3 col-form-label">Name</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" required="" type="text" value="{{ isset($post)?$post->contact_name:'' }}" id="contact_name" name="contact_name" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                            <label for="example-date-input" class="col-sm-3 col-form-label">E-Mail Address</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" required="" type="text" value="{{ isset($post)?$post->contact_email:'' }}" id="contact_email" name="contact_email" >
                                            </div>
                                    </div>

                                    <div class="form-group row">
                                            <label for="example-date-input" class="col-sm-3 col-form-label">Phone Number</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" required="" type="text" value="{{ isset($post)?$post->contact_phone:'' }}" id="contact_phone" name="contact_phone" >
                                            </div>
                                    </div>

                                    <div class="form-group row post-ad">
                                            <label for="example-date-input" class="col-sm-3 col-form-label">Cost</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" value="{{ isset($post)?$post->cost:'' }}" id="cost" name="cost" >
                                            </div>
                                    </div>
                                    <div class="form-group row">
                                            <label for="example-date-input" class="col-sm-3 col-form-label">Photo</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="file" value="" id="image_path" name="image_path" >
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                                <label for="example-date-input" class="col-sm-3 col-form-label">Location</label>
                                                <div class="col-sm-9">
                                                    <select id="location_id" name="location_id" class="form-control" required="">
                                                        <option value=""> -- Select -- </option>
                                                        @foreach($locations as $value)
                                                            <option value="{{$value->id}}" @if(isset($post) &&  $post->location_id == $value->id) selected @endif>{{$value->name}}</option>
                                                        @endforeach
                                                       </select>

                                                </div>
                                            </div>



                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
 <input type="hidden" name="postId" value="{{ isset($post)?$post->id:'' }}" />
 <input type="submit" id="formSubmitBtn" style="display: none;" />
</form>

