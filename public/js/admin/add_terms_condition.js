function saveTermsCondition() {
   $('.alert-danger').hide();
   $('.alert-success').hide();
    $(".ui-loader-background").show();
    //var formData = new FormData($('#terms_condition_form')[0]);
    var description= tinymce.get('description').getContent();
    var introductory= $('#introductory').val();

    $.ajax({
        type: "POST",
        url: SITE_URL + "/add-terms-condition",
        data: {'description': description ,'introductory':introductory},
//        async: true,
//        cache: false,
//        contentType: false,
//        processData: false,
       
        success: function (response) {
            $(".ui-loader-background").hide();
            if (response.success == true) {
                //window.location.href = SITE_URL + '/add-terms-condition';
                 $('#terms_list .alert-success').html(response.message);
                 $('#terms_list .alert-success').show();
            } else {
                if (response.message == '') {
                    $.each(response.result, function (key, value) {
                        $('#terms_list .alert-danger').append($("<li/>", {
                            text: value
                        }));
                    });
                } else {
                    $('#terms_list .alert-danger').html('<li>' + response.message + '</li>');
                }
                $('#terms_list .alert-danger').show();
            }
        },
        error: function (request, status, error) {
            $(".ui-loader-background").hide();
            $('#terms_list .alert-danger').html('<li>Something went wrong. Please contact Benefit Wellness</li>').show();
        }
    });
    return false;
}

$(document).ready(function () {
  
    tinymce.init({
       selector: '#description'
     });
    
});
