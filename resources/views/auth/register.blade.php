@extends('layoutslogin.default')

@section('content')

        

            <div class="card">
                <div class="card-body">

                    <h3 class="text-center mt-0 m-b-15">
                        @if ($crudOrganizationData->count() > 0)
                            @if($crudOrganizationData[0]->orgLogo == "")
                                @php ($orgLogoName = 'assets/uploads/organizations/bible-cross-logo.png')
                            @else
                                @php ($orgLogoName = 'assets/uploads/organizations/'.$crudOrganizationData[0]->orgId.'/org_logo/'.$crudOrganizationData[0]->orgLogo)
                            @endif

                            <a href="" class="logo logo-admin"><img src="{{ URL::asset($orgLogoName)}}" alt="" height="55" class="logo-large"></a>
                        @else
                            <a href="" class="logo logo-admin"><img src="{{ URL::asset('assets/theme/images/bible-cross-logo.png')}}" alt="" height="55" class="logo-large"></a>
                        @endif                        
                    </h3>

                    <h4 class="text-muted text-center font-18"><b>Set Up Your Account</b></h4>

                    <div class="p-3">
                        @if ($errors->any())
                        <div class="error">
                            <ul style="list-style: none;padding: 0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                        @endif
                        
                        
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        
                        {!! Form::open(array('id'=>'memberCreateForm','name'=>'memberCreateForm','method' => 'post', 'url' => url('member_register'), 'class' => 'form-horizontal m-t-20')) !!}
                        @csrf

                            <!-- <div class="form-group">
                                <label >Your Church or Organization Name</label>
                                <div class="col-sm-12">
                                    <input id="orgName" type="text" class="form-control @error('orgName') is-invalid @enderror" name="orgName" value="{{ old('orgName') }}"    autofocus required >
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label >Your Name</label>
                                <div class="col-sm-12">
                                    <input type="hidden" name="orgId" id="orgId" value="{{$crudOrganizationData[0]->orgId}}" />
                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}"    autofocus required >
                                </div>
                            </div>
                            <div class="form-group">
                                <label >Your email</label>
                                <div class="col-sm-12">
                                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"    autofocus required >
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label >Username for login</label>
                                <div class="col-sm-12">
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}"    autofocus required >
                                </div>
                            </div> -->
                            
                            <div class="form-group">
                                <label >Choose a Password</label>
                                <div class="col-sm-12">
                                    <input class="form-control" name="password" id="password" type="password" value="" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label >Confirm Password</label>
                                <div class="col-sm-12">
                                    <input class="form-control" name="confirm_password" id="confirm_password" type="password" value="" >
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label >Timezone</label>
                                <div class="col-sm-12">
                                    {!! $dateTimezone !!}
                                </div>
                            </div> -->

                        

                            <div class="form-group">
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label font-weight-normal" for="customCheck1">I accept <a href="#" class="text-muted">Terms and Conditions</a></label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-center m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-info btn-block waves-effect waves-light" id="btnCreateMember" type="button">Register</button>
                                </div>
                            </div>

                            <div class="form-group m-t-10 mb-0">
                                <div class="col-12 m-t-20 text-center">
                                    <a href="{{URL::asset('login').'/'.$crudOrganizationData[0]->orgDomain}}" class="text-muted">Already have account?</a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
         
<script src="{{ URL:: asset('js/custom/member_register.js')}}"></script>
@endsection

