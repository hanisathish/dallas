@extends('layouts.default')
@section('content')
<div style="width:100vw">
	<div class="row">
	<div class="col-md-12 pb-0" style="background-color:#4d5467">
		<div class="card-body pb-0">
			<h4 class="text-white mb-5">Change Password</h4>
		</div>
	</div>
	</div>

    <?php
        $formUrl = "people/change_password"; 
    ?>
    <div class="row">
        <div class="col-sm-0 col-md-1 col-lg-2"></div>
        <div class="col-sm-12 col-md-10 col-lg-8 card">
            <div class="card-body pl-0 pr-0">
                <h5 class="mt-0 pl-3"> Change Password </h5>
                <hr />
                <div class="row p0 m-0">
         {!! Form::open(array('id'=>'changePasswordForm','name'=>'changePasswordForm','method' => 'post', 'url' => $formUrl, 'class' => 'changePasswordForm col-sm-12 card p-2','files' => true)) !!}
                    					    
                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30">
                                    <div class="card-body">
									
									<div class="form-group row">
										<label class="block clearfix">
										<span class="block input-icon input-icon-right">
										    <span id="msg"></span>
										</span>
										</label>
									</div>
							
								   <div class="form-group row">
										<label for="example-text-input" class="col-sm-2 col-form-label">Current Password</label>
										<div class="col-sm-10">
											{!! Form::password('cur_pwd',['id'=>'cur_pwd','autocomplete'=>'off','placeholder' => 'Current Password','class'=>'form-control']) !!}
										</div>
								   </div>

                                    <div class="form-group row">
										<label for="example-text-input" class="col-sm-2 col-form-label">New Password</label>
										<div class="col-sm-10">
											{!! Form::password('new_pwd',['id'=>'new_pwd','autocomplete'=>'off','placeholder' => 'New Password','class'=>'form-control']) !!}
										</div>
								   </div>


                                    <div class="form-group row">
										<label for="example-text-input" class="col-sm-2 col-form-label">Confirm Password</label>
										<div class="col-sm-10">
											 {!! Form::password('rep_pwd',['id'=>'rep_pwd','autocomplete'=>'off','placeholder' => 'Confirm Password','class'=>'form-control']) !!}
										</div>
								   </div>								   
										
									<div class="form-group">											   
										<div>
											<button type="button" id="changePwd" class="btn btn-primary waves-effect waves-light">
												Update

											</button>
											<a href="{{ URL::asset('people/change_password')}}" type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</a>
										</div>
									 </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </form>
                </div>
            </div>
            <!-- </div> -->
        </div>
    </div>
</div>


<script type='text/javascript'>

$("#changePwd").click(function() {
	
    //alert('clicked');
	
    var cur_pwd = $("#cur_pwd").val();
    var new_pwd = $("#new_pwd").val();
    var rep_pwd = $("#rep_pwd").val();
    if (new_pwd != rep_pwd)
    {
        $("#msg").css({"color": "red"});
        $("#msg").html("New Password and Confirm Password do not match. Please try again.");
        return false;
    }

    var dataString = 'cur_pwd=' + encodeURIComponent(cur_pwd) + '&new_pwd=' + encodeURIComponent(new_pwd) + '&rep_pwd=' + encodeURIComponent(rep_pwd);
    
	//alert(dataString);
	
	
    $.ajax({
        type: "POST",
        async: false,
        data: dataString,
        url: siteUrl + '/people/change_password',
        dataType: "JSON", 
        success: function(data)
        {
            if (data.status === false)
            {
                var errorsHtml = '';
                var errors = data.errors;
                var type = "";
                $.each(errors, function(key, value) {
                    
                    if (key == 'error') {
                        errorsHtml = "<span class='error'>"+value+"</span>";
                        type = 'error';
                    }
                    else if(key == 'success') {
                        errorsHtml = value;
                        type = 'success';
                        $("#msg").css({"color": "green"});
                        $("#cur_pwd").val('');
                        $("#new_pwd").val('');
                        $("#rep_pwd").val('');
                    }
                    else {
                        errorsHtml += "<span class='error'>"+value[0]+"</span>";
                        type = 'error';
                        $("#msg").css({"color": "red"});
                    }
                    
                });

                $("#msg").html(errorsHtml);
               
            }


        },
        error: function(data)
        {
            var errors = '';
            for (datas in data.responseJSON) {
                errors += data.responseJSON[datas] + '<br>';
            }
            $("#msg").addClass('error');
            $('#msg').show().html(errors); //this is my div with messages            
            //console.log(errors);
        }

    });
    return false;

});
</script>


@endsection