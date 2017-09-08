function showActivationList() {
    $ecosystemId = $('.btn-deleteCodes').data('ecosystem-id');
    if ($('#activation_list').length) {
        var table;
        table = $('#activation_list').DataTable({
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
                    data: 'code_id',
                    name: 'code_id',
                     render: function (data, type, row) {

                         if(row.is_used == Const.$isUsed || row.status == Const.$codeInactive){
                             return '<input type="checkbox" value="'+row.code_id+'" name=id[] disabled/>'; 
                         }else{
                              return '<input type="checkbox" value="'+row.code_id+'" name=id[] />'; 
                         }
                     
                    }

                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'mail',
                    name: 'mail'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'surname',
                    name: 'surname'
                },
                {
                    data: 'company',
                    name: 'company'
                },
                {
                    data: 'department',
                    name: 'department'
                },
                 {
                    data: 'is_used',
                    name: 'is_used'
                 }
            ],
            ajax: SITE_URL + '/' + 'code-data/'+$ecosystemId
        });

        $('#activation_list').on('page.dt', function () {
            $('#code-select-all').prop('checked', false);
        });

        /* Check all checkboxes */
        $('#code-select-all').on('click', function () {
            var rows = table.rows({
                page: 'current'
            }).nodes();
            // Check/uncheck checkboxes for all rows in the table
            $('input[type="checkbox"]:not(:disabled)', rows).prop('checked', this.checked);
        });

        // Handle click on checkbox to set state of "Select all" control
        $('#activation_list tbody').on('change', 'input[type="checkbox"]', function () {
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
        $('.btn-deleteCodes').on('click', function (e) {
            $ecosystemId = $('.btn-deleteCodes').data('ecosystem-id');
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
                            deleteActivationCodes(ids,$ecosystemId);
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
    }


}

function deleteActivationCodes(ids,ecosystemId) {
    $(".ui-loader-background").show();
    $.ajax({
        type: "POST",
        url: SITE_URL + "/delete-activationcode",
        data: {
            ids: ids
        },
        success: function (response) {
            $(".ui-loader-background").hide();
            if (response.success == true) {
                window.location.href = SITE_URL + '/code-listing/'+ecosystemId;
            } else {
                if (response.message == '') {
                    $.each(response.result, function (key, value) {
                        $('#activation_code .alert-danger').append($("<li/>", {
                            text: value
                        }));

                    });
                } else {
                    $('#activation_code .alert-danger').html('<li>' + response.message + '</li>');
                }

                $('#activation_code .alert-danger').show();



            }

        },
        error: function (request, status, error) {
            $(".ui-loader-background").hide();
            $('#activation_code .alert-danger').html('<li>Something went wrong. Please contact Benefit Wellness</li>').show();
        }

    });
    return false;

}
$(document).ready(function () {
    showActivationList();
}); 

