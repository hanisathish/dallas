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

                    <h4 class="text-muted text-center font-18"><b>Forgot Password</b></h4>

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
                        
                        {!! Form::open(array('id'=>'forgotPasswordForm','name'=>'forgotPasswordForm','method' => 'post', 'url' => url('forgot_password'), 'class' => 'form-horizontal m-t-20')) !!}
                        @csrf
                        
                            <div class="form-group">
                                <label >Your Email</label>
                                <div class="col-sm-12">
                                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autofocus required >
                                </div>
                            </div>

                            <div class="form-group text-center m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-info btn-block waves-effect waves-light" id="btnforgotPassword" type="button">Submit</button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
         
<script src="{{ URL:: asset('js/custom/forgot_password.js')}}"></script>
@endsection

