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
    <div class="col-md-12">
        <div class="card m-b-30 text-white card-danger" >
            <div class="card-body">
                <div class="media m-b-30">
                    
                    <div class="media-body">
                        <div class="row">
                            
                            <div class="col-md-4 col-lg-4 col-xl-2">

                                
                                <img class="d-flex mr-3 rounded-circle" src="http://localhost/dallas/public/assets/theme/images/users/avatar-6.jpg" alt="Generic placeholder image" height="124">
                                <a href="#" style="text-align: right;" class=""><i class="fa fa-edit"></i> </a>    
                                <!-- text-align: right;float: right; -->

                            </div><!-- end col -->

                            <div class="col-md-4 col-lg-4 col-xl-3">
                                <h3>First Name<button href="#" style="" type="button" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</button>    </h3>
                                

                            </div><!-- end col -->

                            <div class="col-md-10 col-lg-10 col-xl-6">
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


                            </div><!-- end col -->

 
                
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
</div>

<div class="row">
    <div class="col-lg-3">

        @include('members.member_profile_sidebar')
        
    </div>

    <div class="col-lg-9">
        <div class="card m-b-30">
            
            <div class="card-body">
                <h4 class="mt-0 header-title"><i class="fa fa-envelope-open-o"></i> Recent Email — Received</h4>
                
                <table class="table">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Sent</th>
                        <th>From</th>
                        <th>Subject</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>In</td>
                        <td>07/15/2019</td>
                        <td>asdasd@asda.com</td>
                        <td>Hello</td>
                    </tr>
                    <tr>
                        <td>In</td>
                        <td>11/15/2019</td>
                        <td>dede@asda.com</td>
                        <td>fiiiadsa</td>
                    </tr>
                    
                    </tbody>
                </table>
            </div>

        </div>
    </div>
 
</div>
<!-- end row -->

@endsection
