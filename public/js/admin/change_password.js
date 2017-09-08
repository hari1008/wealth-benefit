function change_form_submit() {
    $('#change_password .alert').hide().html('');
   
    $(".ui-loader-background").show();
    var formData = new FormData($('#change_pswd_form')[0]);
    $.ajax({
        type: "POST",
        url: SITE_URL + "/change-password",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.success == true) {
                $('#change_password .alert-success').html(response.message).show();
                $("#oldPassword").val('');
                $("#newPassword").val('');
                $("#confirmPassword").val('');
            } else {
                if (response.message == '') {
                    $.each(response.result, function (key, value) {
                        $('#change_password .alert-danger').append($("<li/>", {
                            text: value
                        }));

                    });
                } else {
                    $('#change_password .alert-danger').html('<li>' + response.message + '</li>');
                }

                $('#change_password .alert-danger').show();



            }


        },
        error: function (request, status, error) {
            $('#change_password .alert-danger').html('<li>Something went wrong. Please contact Benefit Wellness</li>').show();
        }

    });
    $(".ui-loader-background").hide();
    return false;
}
$(document).ready(function () {
    $('#change_password .alert').hide().html('');
    
//    $.validator.addMethod('isValid', function (value, element) {
//        return this.optional(element) || (value.match(/[a-zA-Z]/) && value.match(/[0-9]/));
//    }, 'Password must contain at least one numeric and one alphabetic character.');
    
    if ($("#change_pswd_form").length > 0) {
        var changepwd_form = $("#change_pswd_form");
        changepwd_form.validate({
            errorPlacement: function errorPlacement(error, element) {
                element.after(error);
            },
            rules: {
                oldPassword: {
                    required: true,
                    //alphanumeric: true,
                    minlength: 6,
                    maxlength: 15
                },
                newPassword: {
                    required: true,
                    //alphanumeric: true,
                    minlength: 6,
                    maxlength: 15
                    
                   // isValid: true

                },
                confirmPassword: {
                    required: true,
                    equalTo: "#newPassword"
                }

            },
            messages: {
                oldPassword: "Current password is required.",
                newPassword: {
                    required: "New password is required."
                },
                confirmPassword: {
                    required: "Confirm password is required.",
                    equalTo: "Confirm password should match to new password"
                }

            },
            submitHandler: function (form, event) {
                change_form_submit();
            }
        });
    }
}); 