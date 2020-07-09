@extends('layouts.default')

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success" role="alert">
        {{ session()->get('message') }}
    </div>
@endif

<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item active">Communication Settings</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">

                <h4 class="mt-0 header-title">Communication Messages / Emails content Settings</h4>
                <div class="tab-content">
                    <div class="tab-pane active p-3" id="allusers" role="tabpanel">
                        <table id="userdatatable" class="table table-bordered">
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
    </div> <!-- end col -->
</div> <!-- end row -->
@include('popup.settings.communication')
<script src="{{ URL:: asset('assets/theme/plugins/tinymce/tinymce.min.js')}}"></script>
<script src="{{ URL:: asset('assets/theme/plugins/tinymce/jquery.tinymce.min.js')}}"></script>
<script src="{{ URL:: asset('js/fetch_api_call.js')}}"></script>
<script src="{{ URL:: asset('js/settings/communication.js')}}"></script>
@endsection