function importFile() {
    
    $(".ui-loader-background").show();
    $(".hiddenEle").show();
    $('#importcsv .alert').hide().html('');
    var formData = new FormData($('#importform')[0]);

    $.ajax({
        type: "POST",
        url: SITE_URL + "/import-excel",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            $(".ui-loader-background").hide();
            if (response.success == true) {
                $('#importcsv .alert-success').html(response.message).show();
                $('#importform input[name="import_file"]').val('');
            } else {
                if (response.message == '') {
                  
                    $.each(response.result, function (key, value) {
                        $('#importcsv .alert-danger').append($("<li/>", {
                            text: value
                        }));

                    });
                } else if (response.message != '') {
                    
                    $('#importcsv .alert-danger').html(response.message);
                    var errorRow = '';
                    $.each(response.result, function (key, value) {
                        errorRow = value.row;
                        $.each(value.error, function (key, value) {
                            $('#importcsv .alert-danger').append($("<li/>", {
                                text: "Row: " + errorRow + " Error field: " + key + " Error: " + value
                            }));

                        });

                    });
                } else {
                  
                    $('#importcsv .alert-danger').html(response.message );
                }
                $('#importcsv .alert-danger').show();
            }
        },
        error: function (request, status, error) {

            $('#importcsv .alert-danger').html('<li>Something went wrong. Please contact Benefit Wellness</li>').show();
        }

    });
    return false;
}
$(document).ready(function () {
    $('#importcsv .alert').hide().html('');
});
