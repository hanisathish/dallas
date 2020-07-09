@extends('layouts.default')

@section('content')

    <!-- <div style="width:100vw"> -->

        <div class="row">
            <div class="col-md-12">
                <div class="" style="background-color:#4d5467">
                    <div class="card-body" style="padding-bottom:0px;">
                        <div class="row no-gutters">
                        <div class="col-md-2">
                            <img src="{{$groupDetails->img}}" style="max-width:200px" />
                        </div>
                        <div class="col-md-10 group-details-desc">
                            <div>
                                {{ucwords($groupDetails->name)}}
                            </div>
                            <div>
                                {{ucwords($groupDetails->group_type_name)}} <span>{{($groupDetails->isPublic==1)?"Public group":"Private group"}}</span>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-md-2">

                <ul class="nav flex-column group-menu">
                    <li class="nav-item">
                    <a class="nav-link" href="{{url('')}}/groups/details/{{$groupDetails->id}}/members">Members</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{url('')}}/groups/details/{{$groupDetails->id}}/events">Events</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{url('')}}/groups/details/{{$groupDetails->id}}/resources">Resources</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{url('')}}/groups/details/{{$groupDetails->id}}/settings">Settings</a>
                    </li>
                  </ul>

                    </div>
                </div>

                <div class="col-md-8">
                </div>

            </div>
        </div>


    <!-- </div> -->
@endsection
