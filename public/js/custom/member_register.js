
$(document).ready(function () {


    chkValidateStatus = "";
    chkValidateStatus = $("#memberCreateForm").validate({
        //ignore:[],// false,
        ignore: false,
        errorClass: "error",
        rules: {
            orgId: {
                required: true                
            },
            first_name: {
                required: true
            },
            email: {
                required: true,
                email:true,
                uniqueEmailPerOrganization:true
            },
            password: {
                required: true,
                minlength : 5

            },
            confirm_password: {
                required: true,
                minlength : 5,
                equalTo : "#password"
            }
        },
        messages: {
            orgId: {
                required: "Oraganization name is missing"
            },
            first_name: {
                required: "Please enter name"
            },
            email: {
                required: "Please enter email",
                email: "Please enter valid email"
            },
            password: {
                required: "Please enter password"
            },
            confirm_password: {
                required: "Please enter confirm_password"
            },
        }
    });

});
 

//DUPLICATE BRANCH CODE WITH SAME ACCOUNT HEAD TYPE VALIDATION
    $.validator.addMethod("uniqueEmailPerOrganization", function(ahSiteId, element) {
        //alert('ss');
        var mydata1 = null;
        var orgId = $.trim($('#orgId').val());
        var email = $.trim($('#email').val());
        
        var dataString = 'orgId='+orgId+'&email='+email;
        //alert(dataString);
        $.ajax({
            type: "POST",
            async: false,
            data: dataString,
            url: siteUrl+'/check_unique_email_per_org',
            success: function(data){
                //alert(data);
                if (data == "found"){
                    mydata1 = data;
                }
            }
        });
        return (mydata1 != "found");
    }, 'This Email is already exist for this organization');
    
$("#btnCreateMember").click(function () {

    var formObj = $('#memberCreateForm');
    var formData = new FormData(formObj[0]);

    $("#memberCreateForm").valid();

    var errorNumbers = chkValidateStatus.numberOfInvalids();

    if (errorNumbers == 0) {
               $("#memberCreateForm").submit();


    } else {

    }
});

//form submission
$('#memberCreateForm').submit(function (e) {
    var errorNumbers = chkValidateStatus.numberOfInvalids();
    if (errorNumbers == 0) {
        return true;
    }
    else
    {
    
    }
});