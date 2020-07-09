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

                    <h4 class="text-muted text-center font-18"><b></b></h4>

                     <div class="p-3">
                        <div class="panel panel-body login-form">
                            <p>Please check your email for instructions to reset your password.</p>
                         </div>                        
                    </div>

                </div>
            </div>
         
@endsection

