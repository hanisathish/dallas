@extends('layouts.default')

@section('content')
    <div style="width:100vw">
    @include('settings.schedule.header')
        <div class="row m-5 pl-2 pr-2">
            <div class="col-sm-0 col-md-1 col-lg-2"></div>
            <div class="col-sm-12 col-md-10 col-lg-8 card">
                <!-- <div class="card m-b-30"> -->
                    <div class="card-body pl-0 pr-0">
                        <h5 class="mt-0 pl-3"> {{$schedule->title}}
                        <a href="{{ URL::asset('/settings/schedulling')}}" class="btn btn-secondary btn-sm pull-right ml-3">Back to List</a>
                            <a href="{{ URL::asset('/settings/schedulling/manage/'. $schedule->id)}}" class="btn btn-primary btn-sm pull-right">Edit</a>
                        </h5><hr/>
                        <div class="row card pane p-0 m-0">
                            @if(count($schedule->members) <= 0)
                                <div class="col-sm-12 card-body">
                                    <h6 class="text-secondary">Schedule has not been assign to any Member</h6>
                                </div>
                            @else
                                <div class="col-sm-12 card-body">
                                        <div class="card-title">
                                            <h6>Members Details</h6>    
                                        </div>
                                    @foreach($schedule->members as $member)
                                        <div class="list-group-item list-group-item-action hover-focus">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    @if(isset($member->profile_pic))
                                                    <?php
                                                        $picData = json_decode(unserialize($member->profile_pic));
                                                        $member->profile_pic = $picData->download_path . $picData->original_filename;
                                                    ?>
                                                        <img src="{{URL::asset($member->profile_pic)}}" width="75" height="75">
                                                    @else
                                                        <img src="{{URL::asset('/assets/uploads/organizations/avatar.png')}}" width="75" height="75">
                                                    @endif
                                                </div>
                                                <div class="col-sm-9">
                                                    <h6 class="no-margin">{{$member->full_name}}</h6>
                                                    <p class="text-muted no-padding no-margin">
                                                        {{$member->mobile_no? $member->mobile_no: "No Mobile Number"}}
                                                    </p>
                                                    <p class="text-muted no-padding no-margin">{{$member->email}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row card pane p-0 m-0 mb-4">
                        <div class="card-title mb-0 pl-3">
                            <h5 class="mb-0">Event</h5>
                        </div>
                        <hr/>
                        <div class="col-sm-12 card-body pt-0">
                            <div class="row mb-4">
                                <div class="col-sm-3"><h6 class="m-0">Type of Event</h6></div>
                                <div class="col-sm-9"><strong>{{$schedule->event->eventName}}</strong></div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-3"><h6 class="m-0">Location</h6></div>
                                <div class="col-sm-9"><strong>{{"Location".$schedule->location}}</strong></div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-3"><h6 class="m-0">Building Block</h6></div>
                                <div class="col-sm-9"><strong>{{"Building".$schedule->location}}</strong></div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-3"><h6 class="m-0">Date</h6></div>
                                <div class="col-sm-9"><strong>{{$schedule->date}}</strong></div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-3"><h6 class="m-0">Time</h6></div>
                                <div class="col-sm-9"><strong>{{$schedule->time}}</strong></div>
                            </div>
                        </div>
                    </div>
                    <div class="row card pane p-0 m-0 mb-4">
                        <div class="card-title mb-0 pl-3">
                            <h5 class="mb-0">Volunteer</h5>
                        </div>
                        <hr/>
                        <div class="col-sm-12 card-body pt-0">
                            <div class="row mb-4">
                                <div class="col-sm-3"><h6 class="m-0">Type of Volunteer</h6></div>
                                <div class="col-sm-9 text-capitalize"><strong>{{$schedule->volunteer->mldValue}}</strong></div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-3"><h6 class="m-0">Quantity</h6></div>
                                <div class="col-sm-9"><strong>{{$schedule->checker_count}}</strong> (max of 10)</div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-3"><h6 class="m-0">Notification</h6></div>
                                <div class="col-sm-9">
                                    <strong>
                                        @if($schedule->notification_flag == 1) None
                                        @elseif($schedule->notification_flag == 2) SMS Only
                                        @elseif($schedule->notification_flag == 3) Email Only
                                        @else SMS and Email Both
                                        @endif
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row card pane p-0 m-0 mb-4">
                        <div class="card-title mb-0 pl-3">
                            <h5 class="mb-0">Notifications</h5>
                        </div>
                        <hr/>
                        <div class="col-sm-12 card-body pt-0">
                            <strong class="text-secondary"> !! Waiting for Notification Requirements and Workflow procedure !! </strong>
                        </div>
                    </div>
                <!-- </div> -->
            </div>
        </div>
    </div>
    <script src="{{ URL:: asset('js/fetch_api_call.js')}}"></script>
    <script src="{{ URL:: asset('js/custom.js')}}"></script>
    <script src="{{ URL:: asset('js/settings/schedule/details.js')}}"></script>
@endsection