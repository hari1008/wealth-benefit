function showList() {

    if ($('#work_listing').length) {
        var url = '';
        url = SITE_URL + '/' + 'work-data';

        var table;
        table = $('#work_listing').DataTable({
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
                    data: 'work_id',
                    name: 'work_id',
                   render: function (data, type, row) {
                        return    '<input type="checkbox" value= "'+row.work_id+'" name=id[] />';
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
                    data: 'work_name',
                    name: 'work_name'
                },

                {
                    data: 'type',
                    name: 'type',
                    render: function (data, type, row) {
                        if(row.type == 1){
                            return "Gym";
                        }
                        else if(row.type == 2){
                            return "Medical Group";
                        }
                        else if(row.type == 3){
                            return "Hotel";
                        }
                        else{
                            return "Government";
                        }
                    }
                }, 
                {
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
        $('.btn-deleteWork').on('click', function (e) {
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
                            deleteWork(ids);
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
        $('.btn-editWork').on('click', function (e) {
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
                openEditWorkPage(ids);
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


function deleteWork(ids) {
    
    $(".ui-loader-background").show();
    
    $.ajax({
        type: "POST",
        url: SITE_URL + "/delete-work",
        data: {
            ids: ids
        },
        success: function (response) {
            $(".ui-loader-background").hide();
            if (response.success == true) {
                window.location.href = SITE_URL + '/work-listing';
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

function openEditWorkPage(id) {
    window.location.href = SITE_URL + '/work?id=' + id;
}

function save_work_form_submit() {
    $(".ui-loader-background").show();
    var formData = new FormData($('#save_work_form')[0]);
    $('#work_list .alert').hide().html('');

    $.ajax({
        type: "POST",
        url: SITE_URL + "/save-work",
        data: formData,
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            $(".ui-loader-background").hide();
            if (response.success == true) {
                window.location.href = SITE_URL + '/work-listing';
            } else {
                if (response.message == '') {
                    $.each(response.result, function (key, value) {
                        $('#work_list .alert-danger').append($("<li/>", {
                            text: value
                        }));
                    });
                } else {
                    $('#work_list .alert-danger').html('<li>' + response.message + '</li>');
                }
                $('#work_list .alert-danger').show();
            }
        },
        error: function (request, status, error) {
            $(".ui-loader-background").hide();
            $('#work_list .alert-danger').html('<li>Something went wrong. Please contact Benefit Wellness</li>').show();
        }
    });
    return false;
}

$(document).ready(function () {
    showList();
    // save insurance
    if ($("#save_work_form").length > 0) {
        $("#save_work_form").trigger('reset');

        var save_work_form = $("#save_work_form");
        save_work_form.validate({
            errorPlacement: function errorPlacement(error, element) {
                if(element[0].name == "logo") {
                    element.parents('.logoGroup').append(error);
                } else {
                    element.after(error);
                }
            },
            rules: {
                work_name: {
                    required: true
                },
                logo: {
                    required_image: true
                }
            },
            messages: {
                name: {
                    required: "Work name is required."
                },
                logo: {
                    required: "Health insurance logo is required."
                }
            },
            submitHandler: function (form, event) {
                save_work_form_submit();
            }
        });
    }
     /* Custom single select dropdown */
    $(document.body).on('click', '.custom_select.dropdown-menu li', function (event) {
        var $target = $(event.currentTarget);
        var ele = $(this);
        $target.closest('.btn-group').find('input[type="hidden"]').val(ele.find('a').attr('data-val'));
        $target.closest('.btn-group').find('[data-bind="label"]').text($target.text()).end().children('.dropdown-toggle').dropdown('toggle');
        $(this).parents('.btn-group').find('button.dropdown-toggle').valid();
        return false;
    });
    /* End Custom single select dropdown */
});
