<div class="col-md-12">
        <div class="card m-b-30 text-white card-warning" >
            <div class="card-body">
                <!-- <div class="media m-b-30">

                    <div class="media-body"> -->
                        <div class="row">

                            <div class="col-md-4 col-lg-4 col-xl-3">


                                <img class="d-flex mr-3 " src="{{$groupDetails->img}}" alt="Generic placeholder image" height="128">
                            </div><!-- end col -->

                            <div class="col-md-6 col-lg-6 col-xl-7">

                                    <h4 class="card-title font-20 mt-0"> {{ucwords($groupDetails->name)}}</h4>
                                    <p class="card-text">{{($groupDetails->description)}}</p>
                                    <a href="#" class="btn btn-light btn-sm">{{ucwords($groupDetails->group_type_name)}}</a>

                            </div><!-- end col -->
                            <?php $domainData = \App\Models\Organization::find(Session::get('userSessionData')['umOrgId']); 
                            $orgUrl = $domainData['orgDomain'].'/groups/';
                            ?>

                            <div class="col-md-2 col-lg-2 col-xl-2">
                                <a href="<?php echo url($orgUrl);?>" class="btn btn-info btn-sm" target="_blank">Open Group In Public Page</a>
                            </div>

                            <!-- end col -->
                        </div>
                    <!-- </div>
                </div> -->

            </div>
        </div>
    </div>
