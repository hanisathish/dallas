@extends('layouts.default')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item ">Groups</li>
                    <li class="breadcrumb-item active">Groups Details</li>
                </ol>
            </div>
            <!--<h4 class="page-title">Member Directory</h4>-->

        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">

    @include('groups.groups_details_header_block')

</div>

<div class="row">
    <div class="col-lg-3">

        @include('groups.groups_details_sidebar')

    </div>
    <?php $template = "groups.group.".$activeTab; ?>
    @include($template)

</div>
<!-- end row -->



<script src="{{ URL::asset('assets/crop/croppie.js') }}"></script>

<link rel="stylesheet" href="{{ URL::asset('assets/crop/croppie.css') }}">



@endsection
