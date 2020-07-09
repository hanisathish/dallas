
function eventDateChanged(ev) {

    //alert("selecteventdate2"+ev.target.value);
    var datastring = "event_date="+ev.target.value;
    //alert(datastring+"--"+siteUrl);
    $.ajax({
        url: siteUrl + '/events/get_events_upon_date/'+ev.target.value,
        async: true,
        type: "GET",
        data: datastring,
        dataType: "html",
        // contentType: false,
        // cache: false,
        // processData: false,
        success: function (data)
        {
            //alert("s");
            console.log(data);
            $("#load_events").html(data);

            $("#event_id").val($("#event_id_hidden").val()).change();
        }

    }); 
    // $(this).datepicker('hide');
    // if ($('#startdate').val() != '' && $('#enddate').val() != '') {
    //     $('#period').text(diffInDays() + ' d.');
    // } else {
    //     $('#period').text("-");
    // }
}


/*
// Setup validation
    // ------------------------------

    // Initialize
    var validator = $(".givingsForm").validate({
        ignore: 'input[type=hidden], .select2-input', // ignore hidden fields
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },

        // Different components require proper error label placement
        errorPlacement: function(error, element) {

            // Styled checkboxes, radios, bootstrap switch
            if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                    error.appendTo( element.parent().parent().parent().parent() );
                }
                 else {
                    error.appendTo( element.parent().parent().parent().parent().parent() );
                }
            }

            // Unstyled checkboxes, radios
            else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
                error.appendTo( element.parent().parent().parent() );
            }

            // Inline checkboxes, radios
            else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo( element.parent().parent() );
            }

            // Input group, styled file input
            else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                error.appendTo( element.parent().parent() );
            }
            else {
                error.insertAfter(element);
            }
        },
        validClass: "validation-valid-label",
        success: function(label) {
            label.addClass("validation-valid-label").text("")
        },
        rules: {
            //vali: "required",
            type: {
                required : true
            },
            amount: {
                required : true                
            }
        },
        messages: {
            type: {
                required: "Please select payment type",
            },
            amount: {
                required: "Please enter Amount",
            },
        }
    });


    // Reset form
    $('#reset').on('click', function() {
        validator.resetForm();
    });


*/


$(document).ready(function () {
    

    chkGivingCreateValidateStatus = "";
    chkGivingCreateValidateStatus = $("#givingsForm").validate({
        //ignore:[],// false,
        ignore: false,
        errorClass: "error",
        rules: {
            type: {
                required: true                
            },
            amount: {
                required: true
            },
            payment_gateway_id: {
                required: true
            }
        },
        messages: {
            type: {
                required: "Please select type"
            },
            amount: {
                required: "Please enter amount"
            },
            payment_gateway_id: {
                required: "Please select payment mode"
            }
        }
    });

});

//form submission
$('#givingsForm').submit(function(e) {
    var errorNumbers = chkGivingCreateValidateStatus.numberOfInvalids();
    if (errorNumbers == 0) {
        return true;
    } else {

    }
});