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
                    
            <h5 class="mt-0 pl-3"><center> Change Password </center> </h5>
            <hr />
            <div class="p-3">			    
                
                {!! Form::open(array('id'=>'changeUserPwdPublicForm','name'=>'changeUserPwdPublicForm','method' => 'post', 'url' => url('customerpwdstore'), 'class' => 'changeUserPwdPublicForm col-sm-12 card p-2','files' => true)) !!}
                    					    
                        			  
                <input type="hidden" name="id" id="id" value="{{ old('id', !empty($getUserLists) ? $getUserLists->id : '') }}" />
			
                <div class="form-group">
					<label class="col-sm-12">Password:</label>
					<div class="col-lg-9">
						<input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-12">Confirm Password:</label>
					<div class="col-lg-9">
						<input type="password" class="form-control" placeholder="Confirm Password" name="repeat_password" id="repeat_password" required>
					</div>
				</div>                              

				<div class="text-right">
					<button type="button" name="submitResetPwdBtn" id="submitResetPwdBtn" class="btn btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>
				</div>
			
			     <div class="form-group m-t-10 mb-0">
                    <div class="col-12 m-t-20 text-center">
                        <a href="{{URL::asset('login').'/'.$crudOrganizationData[0]->orgDomain}}" class="text-muted">Already have account?</a>
                    </div>
                </div>
                                       
                    {!! Form::close() !!}
                    <div class="changepwdspan" id="changepwdspan" style="font-weight: bold;"></div>
            </div>
            
        </div>
    </div>

<script type='text/javascript'>

$(document).ready(function () {


    chkChangePasswordValidateStatus = "";
    chkChangePasswordValidateStatus = $("#changeUserPwdPublicForm").validate({
        //ignore:[],// false,
        ignore: false,
        errorClass: "error",
        rules: {
            
            password: {
                required: true,
                minlength : 5

            },
            repeat_password: {
                required: true,
                minlength : 5,
                equalTo : "#password"
            } 
        },
        messages: {
            password: {
                required: "Please enter password"
            },
            repeat_password: {
                required: "Please enter Confirm Password"
            },
        }
    });

});


$("#submitResetPwdBtn").click(function () {

    var formObj = $('#changeUserPwdPublicForm');
    var formData = new FormData(formObj[0]);

    $("#changeUserPwdPublicForm").valid();

    var errorNumbers = chkChangePasswordValidateStatus.numberOfInvalids();
    $("#changepwdspan").html('');

    if (errorNumbers == 0) {
        $.ajax({
            url: siteUrl + '/customerpwdstore',
            async: true,
            type: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data)
            {
                if(data.result_code == 1){
                    $("#changepwdspan").html(data.message);
                }else{
                    //alert(data.failure);
                    $("#changepwdspan").html(data.message);
                    return false;
                }
                 
            }

        });

    } else {

    }
});

</script>

@endsection