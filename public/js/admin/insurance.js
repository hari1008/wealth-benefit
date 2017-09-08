function showList() {

    if ($('#insurance_listing').length) {
        var url = '';
        url = SITE_URL + '/' + 'insurance-data';

        var table;
        table = $('#insurance_listing').DataTable({
            bDestroy: true,
            processing: true,
            deferRender: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            bLengthChange: false,
            pageLength: 5,
            scroller: true,
            columnDefs: [{
                targets: 0,
                searchable: false,
                orderable: false,
                className: 'dt-body-center no_sorting'
                }],
            columns: [
                {
                    data: 'attribute_id',
                    name: 'attribute_id',
                   render: function (data, type, row) {
                        return    '<input type="checkbox" value= "'+row.attribute_id+'" name=id[] />';
                    }
                },
                {
                    data: 'logo',
                    name: 'logo',
                    render: function (data, type, row) {
                      return    '<img src="' +row.logo + '" alt="" width="40" height="auto">';
                    }
                },
                {
                    data: 'name',
                    name: 'name'
                },

                {
                    data: 'description',
                    name: 'description'
                }, {
                    data: 'created_at',
                    name: 'created_at'
                }

            ],

            ajax: url
        });

        $('#insurance_listing').on('page.dt', function () {
            $('#code-select-all').prop('checked', false);
        });

        /* Check all checkboxes */
        $('#code-select-all').on('click', function () {
            var rows = table.rows({
                page: 'current'
            }).nodes();
            // Check/uncheck checkboxes for all rows in the table
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });

        // Handle click on checkbox to set state of "Select all" control
        $('#insurance_listing tbody').on('change', 'input[type="checkbox"]', function () {
            // If checkbox is not checked
            if (!this.checked) {
                var el = $('#code-select-all').get(0);
                // If "Select all" control is checked and has 'indeterminate' property
                if (el && el.checked && ('indeterminate' in el)) {
                    el.indeterminate = true;
                }
            }
        });
        /* Default uncheck select all button */
        $('#code-select-all').prop('checked', false);


        // Handle Delete Codes
        $('.btn-deleteInsurance').on('click', function (e) {
            e.preventDefault();
            var ele = $(this);
            var ids = Array();
            // Iterate over all checkboxes in the table
            table.$('input[type="checkbox"]').each(function () {
                // If checkbox is checked
                if (this.checked) {
                    ids.push(this.value);
                }
            });
            if (ids.length > 0) {
                BootstrapDialog.confirm({
                    title: 'Confirmation',
                    message: '<strong class="blue">Are you sure you want to delete?</strong>',
                    type: BootstrapDialog.TYPE_PRIMARY,
                    closable: false, // <-- Default value is false
                    btnCancelLabel: 'Cancel', // <-- Default value is 'Cancel',
                    btnOKLabel: 'Delete', // <-- Default value is 'OK',
                    btnOKClass: 'btn-main', // <-- If you didn't specify it, dialog type will be used,
                    callback: function (result) {
                        if (result) {
                            deleteInsurance(ids);
                        }
                    }
                });
            } else {
                BootstrapDialog.show({
                    title: 'Alert',
                    closable: false,
                    message: 'Please select atleast one record',
                    buttons: [{
                        label: 'Ok',
                        action: function (dialog) {
                            dialog.close();
                        }
                        }]
                });
            }
        });
        // Handle Edit Event
        $('.btn-editInsurance').on('click', function (e) {
            e.preventDefault();
            var ele = $(this);
            var ids = Array();
            // Iterate over all checkboxes in the table
            table.$('input[type="checkbox"]').each(function () {
                // If checkbox is checked
                if (this.checked) {
                    ids.push(this.value);
                }
            });
            if (ids.length == 1) {
                openEditInsurancePage(ids);
            } else {
                BootstrapDialog.show({
                    title: 'Alert',
                    closable: false,
                    message: 'Please select one record',
                    buttons: [{
                        label: 'Ok',
                        action: function (dialog) {
                            dialog.close();
                        }
                        }]
                });
            }
        });


    }


}


function deleteInsurance(ids) {
    $(".ui-loader-background").show();
    $.ajax({
        type: "POST",
        url: SITE_URL + "/delete-insurance",
        data: {
            ids: ids
        },
        success: function (response) {
            $(".ui-loader-background").hide();
            if (response.success == true) {
                window.location.href = SITE_URL + '/insurance-listing';
            } else {
                if (response.message == '') {
                    $.each(response.result, function (key, value) {
                        $('#insurance_list .alert-danger').append($("<li/>", {
                            text: value
                        }));

                    });
                } else {
                    $('#insurance_list .alert-danger').html('<li>' + response.message + '</li>');
                }

                $('#insurance_list .alert-danger').show();



            }

        },
        error: function (request, status, error) {
            $(".ui-loader-background").hide();
            $('#insurance_list .alert-danger').html('<li>Something went wrong. Please contact Benefit Wellness</li>').show();
        }
    });
    return false;

}

function openEditInsurancePage(id) {
    window.location.href = SITE_URL + '/insurance?id=' + id;
}

function save_insurance_form_submit() {
    $(".ui-loader-background").show();
    var formData = new FormData($('#save_insurance_form')[0]);
    $('#insurance_list .alert').hide().html('');

    $.ajax({
        type: "POST",
        url: SITE_URL + "/save-insurance",
        data: formData,
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            $(".ui-loader-background").hide();
            if (response.success == true) {
                window.location.href = SITE_URL + '/insurance-listing';
            } else {
                if (response.message == '') {
                    $.each(response.result, function (key, value) {
                        $('#insurance_list .alert-danger').append($("<li/>", {
                            text: value
                        }));
                    });
                } else {
                    $('#insurance_list .alert-danger').html('<li>' + response.message + '</li>');
                }
                $('#insurance_list .alert-danger').show();
            }
        },
        error: function (request, status, error) {
            $(".ui-loader-background").hide();
            $('#insurance_list .alert-danger').html('<li>Something went wrong. Please contact Benefit Wellness</li>').show();
        }
    });
    return false;
}

$(document).ready(function () {
    //$('#insurance_list .alert').hide().html('');
    showList();
    // save insurance
    if ($("#save_insurance_form").length > 0) {
        $("#save_insurance_form").trigger('reset');

        var save_insurance_form = $("#save_insurance_form");
        save_insurance_form.validate({
            errorPlacement: function errorPlacement(error, element) {
                if(element[0].name == "logo") {
                    element.parents('.logoGroup').append(error);
                } else {
                    element.after(error);
                }
            },
            rules: {
                name: {
                    required: true
                },
                logo: {
                    required_image: true
                },
                description: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Health insurance name is required."
                },
                logo: {
                    required: "Health insurance logo is required."
                },
                description: {
                    required: "Health insurance description is required."
                }
            },
            submitHandler: function (form, event) {
                save_insurance_form_submit();
            }
        });
    }
});
