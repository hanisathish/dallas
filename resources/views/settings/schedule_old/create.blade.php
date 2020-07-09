@extends('layouts.default')

@section('content')
    <div style="width:100vw">
    @include('settings.schedule.header')
        <div class="row">
            <div class="col-sm-0 col-md-1 col-lg-2"></div>
            <div class="col-sm-12 col-md-10 col-lg-8 card">
                <!-- <div class="card m-b-30"> -->
                    <div class="card-body pl-0 pr-0">
                        <h5 class="mt-0 pl-3"> {{($schedule_id)? 'Edit' : "Create" }} Schedule</h5><hr/>
                        <div class="row p0 m-0">
                            <input id="scheduleId" value="{{$schedule_id}}" class="d-none">
                            <form id="scheduleForm" class="col-sm-12 card p-2" novalidate></form>
                        </div>
                    </div>
                <!-- </div> -->
            </div>
        </div>
    </div>
    <script src="{{ URL:: asset('js/fetch_api_call.js')}}"></script>
    <script src="{{ URL:: asset('js/custom.js')}}"></script>
    <script src="{{ URL:: asset('js/settings/schedule/create.js')}}"></script>
@endsection