@extends('layouts.default')

@section('content')
    <div style="width:100vw">
        @include('settings.schedule.header')
        <div class="row m-5 pl-4 pr-4">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h5 class="mt-0">Scheduling List<a href="{{ URL:: asset('/settings/schedulling/manage')}}" class="btn btn-sm btn-success pull-right text-white"><i class="fa fa-plus"></i> Create New</a></h5>
                        <hr/>
                        <div class="tab-content">
                            <div class="tab-pane active p-3">
                                <table id="scheduleDatatable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <!-- <th>Volunteer</th> -->
                                            <th>Event</th>
                                            <!-- <th>Time</th>
                                            <th>Date</th> -->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="{{ URL:: asset('js/settings/schedule/index.js')}}"></script>
@endsection