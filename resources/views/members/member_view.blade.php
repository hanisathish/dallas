@extends('layouts.default')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item ">Member Directory</li>
                    <li class="breadcrumb-item active">Member Profile</li>
                </ol>
            </div>
            <!--<h4 class="page-title">Member Directory</h4>-->

        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    
    @include('members.member_profile_header_block')

</div>

<div class="row">
    <div class="col-lg-3">

        @include('members.member_profile_sidebar')

    </div>

    <div class="col-lg-6">
        <div class="card m-b-30">
            <div class="card-header">
                Personal Information
            </div>
            <div class="card-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            @if($user->gender)
                                <i class="fa fa-user"></i><span class="pl-3">{{$user->gender}}</span><br/>
                            @endif 
                            @if(isset($user->age) && isset($user->dob_format))
                                <span class="pl-4">{{$user->age}} years old <span><br/><span class="pl-4">({{$user->dob_format}})</span><br/>
                            @endif
                            @if($user->life_stage)
                                <span class="pl-4">{{$user->life_stage}}</span><br/>
                            @endif
                            @if($user->medical_note)
                                <i class="fa fa-heartbeat"></i> <span class="pl-3">{{$user->medical_note}}</span>
                            @endif

                        </div>
                        <div class="col-6">
                            @if($user->email)
                                <i class="fa fa-envelope"></i><span class="pl-3">{{$user->email}}<span><br/>
                            @endif
                            @if($user->mobile_no)
                                <i class="fa fa-phone"></i><span class="pl-4">{{$user->mobile_no}}</span><br/>
                            @endif
                            @if($user->address)
                                <i class="fa fa-address-card"></i><span class="pl-3">{{$user->address}}</span><br/>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="card-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            <div class="card-header">
                                School
                            </div>
                            <i class="fa fa-apple"></i>&nbsp;{{$user->grade_name}} Grade ({{$user->school_name}})
                        </div>
                        <div class="col-6">
                            <div class="card-header">
                                Social Profiles
                            </div>
                            @if($user->social_profile)
                            <i class="fa fa-facebook"></i>&nbsp;{{$user->social_profile}}<br/>
                            <i class="fa fa-twitter"></i>&nbsp;{{$user->social_profile}}<br/>
                            <i class="fa fa-linkedin"></i>&nbsp;{{$user->social_profile}}<br/>
                            <i class="fa fa-instagram"></i>&nbsp;{{$user->social_profile}}<br/>
                            @else 
                                <h6 class="text-secondary">No Social Profiles</h6>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3" id="household-blocks">
        
    </div>
</div>
<!-- end row -->


 
<script src="{{ URL::asset('assets/crop/croppie.js') }}"></script>

<link rel="stylesheet" href="{{ URL::asset('assets/crop/croppie.css') }}">


@include('popup.household')

@include('popup.modal_popup_member')

<script type="text/javascript">
    $uploadCrop = $('#upload-demo').croppie({
        enableExif: true,
        viewport: {
            width: 128,
            height: 128,
            type: 'circle'
        },
        boundary: {
            width: 300,
            height: 300
        }
    });


    $('#upload').on('change', function () { 
        var reader = new FileReader();
        reader.onload = function (e) {
            $uploadCrop.croppie('bind', {
                url: e.target.result
            }).then(function(){
                console.log('jQuery bind complete');
            });
            
        }
        reader.readAsDataURL(this.files[0]);
    });


    $('.upload-result').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {


            $.ajax({
                url: siteUrl+'/user_profile_file_upload',
                type: "POST",
                data: {"image":resp,"user_id":$("#hidden_user_id").val()},
                success: function (data) {
                    html = '<img src="' + resp + '" />';
                    $("#upload-demo-i").html(html);
                }
            });
        });
    });
</script>

@endsection
