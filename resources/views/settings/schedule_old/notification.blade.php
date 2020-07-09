@extends('layouts.default')

@section('content')
<div style="width:100vw">
        @include('settings.schedule.header')
        <div class="row m-5 pl-4 pr-4">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h5 class="mt-0">Schedule Notifications</h5>
                        <hr/>
                        <div class="tab-content">
                            <div class="tab-pane active p-3">
                                <table id="notificationDatatable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Subject</th>
                                            <th>Actions</th>
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

    @include('popup.settings.communication')

    <script src="{{ URL:: asset('assets/theme/plugins/tinymce/tinymce.min.js')}}"></script>
    <script src="{{ URL:: asset('assets/theme/plugins/tinymce/jquery.tinymce.min.js')}}"></script>
    <script src="{{ URL:: asset('js/fetch_api_call.js')}}"></script>
    <script src="{{ URL:: asset('js/settings/schedule/notification.js')}}"></script>
@endsection