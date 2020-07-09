@extends('layoutslogin.default')

@section('content')


<div class="card">
    <div class="card-body">
        <h3 class="text-center mt-0 m-b-15">
            @if ($crudOrganizationData->count() > 0)
                @if($crudOrganizationData[0]->orgLogo == "")
                    @php ($orgLogoName = 'assets/uploads/organizations/bible-cross-logo.png')
                @else

                    <?php
                    $orgLogo_json = json_decode(unserialize($crudOrganizationData[0]->orgLogo));
                    $orguploaded_file_name = $orgLogo_json->uploaded_file_name;
                    $orguploaded_path = $orgLogo_json->uploaded_path;
                    $orgdownload_path = $orgLogo_json->download_path;
                    $orgLogo = $orgdownload_path.$orguploaded_file_name;
                    //dd($orguploaded_file_name,$orgdownload_path);
                    ?>
                    
                    @php ($orgLogoName = 'assets/uploads/organizations/'.$crudOrganizationData[0]->orgId.'/org_logo/'.$orguploaded_file_name)
                @endif
                <a href="" class="logo logo-admin"><img src="{{ URL::asset($orgLogoName)}}" alt="" height="55" class="logo-large"></a>
            @else
                <a href="" class="logo logo-admin"><img src="{{ URL::asset('assets/theme/images/bible-cross-logo.png')}}" alt="" height="55" class="logo-large"></a>
            @endif
        </h3>

        <h4 class="text-muted text-center font-18"><b>Sign In</b></h4>

        <div class="p-3">
            {{Form::open(array('url' => url('webapp/login'), 'class'=>'form', 'id'=>'login_form','name'=>'login_form'))}}
                        @csrf
            <form class="form-horizontal m-t-20" action="index.html">

                <div class="form-group row">
                    <div class="col-12">
                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- <div class="form-group row">
                    <div class="col-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Remember me</label>
                        </div>
                    </div>
                </div> -->

                <div class="form-group text-center row m-t-20">
                    <div class="col-12">
                        <button class="btn btn-info btn-block waves-effect waves-light" type="submit">Log In</button>
                    </div>
                </div>

                <div class="form-group m-t-10 mb-0 row">
                    <div class="col-sm-7 m-t-20">
                        <a href="{{URL::asset('forgotpassword').'/'.$crudOrganizationData[0]->orgDomain}}" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                    </div>
                    <div class="col-sm-5 m-t-20">
                         <a href="{{URL::asset('register').'/'.$crudOrganizationData[0]->orgDomain}}" class="text-muted"><i class="mdi mdi-account-circle"></i> Create an account</a> 
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection
