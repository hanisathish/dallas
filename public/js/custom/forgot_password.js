$(document).ready(function () {

    chkValidateStatus = "";
    chkValidateStatus = $("#forgotPasswordForm").validate({
        //ignore:[],// false,
        ignore: false,
        errorClass: "error",
        rules: {
            email: {
                required: true,
                email:true
            },
        },
        messages: {
            email: {
                required: "Please enter email",
                email: "Please enter valid email"
            },
        }
    });

});
 
   

	
$("#btnforgotPassword").click(function () {

    var formObj = $('#forgotPasswordForm');
    var formData = new FormData(formObj[0]);

    $("#forgotPasswordForm").valid();

    var errorNumbers = chkValidateStatus.numberOfInvalids();

    if (errorNumbers == 0) {
               $("#forgotPasswordForm").submit();


    } else {

    }
});

//form submission
$('#forgotPasswordForm').submit(function (e) {
    var errorNumbers = chkValidateStatus.numberOfInvalids();
    if (errorNumbers == 0) {
        return true;
    }
    else
    {
    
    }
});