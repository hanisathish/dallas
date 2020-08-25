<div class="col-md-12">
        <div class="card m-b-30 text-white card-danger" >
            <div class="card-body">
                <!-- <div class="media m-b-30">

                    <div class="media-body"> -->
                        <div class="row">

                            <div class="col-md-4 col-lg-4 col-xl-2">
                                <input type="hidden" name="hidden_user_id" id="hidden_user_id" value="{{$user['id']}}">
                                <?php
                                $profile_pic_image= url('/assets/uploads/organizations/avatar.png');
                                if(isset($user['profile_pic'])){
                                    $profile_pic_image_json = json_decode(unserialize($user->profile_pic));
                                    $profile_pic_image = $profile_pic_image_json->download_path.$profile_pic_image_json->uploaded_file_name;
                                }
                                ?>
                                <div id="upload-demo-i" class="d-flex mr-3 rounded-circle">
                                <img class="d-flex mr-3 rounded-circle" src="{{$profile_pic_image}}" alt="" height="128">

                                </div>
                                @if(isset($isCommPage) && $isCommPage)
                                <span></span>
                                @else
                                <a href="" class="btnProfilePicEdit"  data-toggle="modal" data-target="#profilePicModal" style="text-align: right;"><i class="fa fa-edit"></i> </a>    
                                @endif
                                <!-- text-align: right;float: right; -->

                            </div><!-- end col -->
                            <?php
                                $edit_profile_url = URL::asset("/people/member/management");
                                $member_id = request()->route()->parameters['personal_id'];
                                if($member_id){
                                    $edit_profile_url = $edit_profile_url ."/". $member_id;
                                }
                            ?>
                            <div class="col-md-6 col-lg-6 col-xl-7">
                                <h3>{{$user->name_prefix}} {{$user->full_name}} <?php echo ($user->given_name==''?'': '('.$user->given_name.')' );?> <?php echo ($user->nick_name==''?'': ''. $user->nick_name .'');?> <a href={{$edit_profile_url}} style="" type="button" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a></h3>
                            </div><!-- end col -->

                            <!-- <div class="col-md-2 col-lg-2 col-xl-3">
                                <h3></h3>
                                <div class="dropdown mo-mb-2"  style="float: right !important;">
                                    <button type="button" class="btn btn-primary dropdown-toggle-split" data-toggle="dropdown"><i class="fa fa-user"></i></button>
                                    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Member Status
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div> -->
                            <!-- end col -->
                        </div>
                    <!-- </div>
                </div> -->

            </div>
        </div>
    </div>