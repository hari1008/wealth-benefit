function showUserList(flag) {

    if ($('#user_listing').length) {
         var url='';
        if(flag == 0){
                url = SITE_URL + '/'+ 'user-data'
            }else{
                 url = SITE_URL + '/'+ 'user-data?flag='+flag 
            }
        var table;
        table = $('#user_listing').DataTable({
            bDestroy:true,
            processing: true,
            deferRender: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            bLengthChange: false,
            pageLength: 50,
            scroller: true,
            columnDefs: [{
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    className: 'dt-body-center no_sorting'
                }],
            columns: [
                {
                    data: 'user_id',
                    name: 'user_id',
                     render: function (data, type, row) {
                        return    '<input type="checkbox" value= "'+row.user_id+'" name=id[] />';
                    }

                },
                {
                    data: 'image',
                    name: 'image',
                     render: function (data, type, row) {
                      return    '<a href="user-detail/'+row.user_id+'"><img src="' +row.image + '" alt="" width="40" height="auto"> </a>';
                    }

                },
                {
                    data: 'first_name',
                    name: 'first_name'
                },
                {
                    data: 'last_name',
                    name: 'last_name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                 {
                    data: 'user_type',
                    name: 'user_type',
                    render: function (data, type, row) {
                     return row.user_type == Const.$regular ? "Regular" : (row.user_type == Const.$plus  ? "Regular Plus" : "Expert");
                 }
                },
                {
                    data: 'last_name',
                    name: 'last_name',
                    render: function (data, type, row) {
                        if(row.ecosystem){
                            return row.ecosystem.ecosystem_name;
                        }
                        else{
                            return '-';
                        }
                    }
                },
                
                {
                    data: 'expert_type',
                    name: 'expert_type',
                    render: function (data, type, row) {
                       return row.expert_type == Const.$expertAsPersonalTrainer ? "Personal Trainer" :row.expert_type == Const.$expertAsHealthProfessional ? "Health Professional" : '-';
                    }
                },
                {
                  data: 'action',
                  name: 'action',
                   render: function (data, type, row) {
                     
                       if (row.user_type == Const.$plus || row.user_type == Const.$regular ) {
                                
                                return row.is_interested_for_expert == Const.$isInterestedForExpert ? '<a title= "approve" href= "javascript:void(0)" onClick="approveAsExpert('+row.user_id+','+row.user_type+')" class=""><i class="fa fa-check-square-o"></i></a>&nbsp;<a title= "disapprove" href= "javascript:void(0)" onClick="disapproveAsExpert('+row.user_id+','+row.user_type+')" class=""><i class="fa fa-times-circle"></i></a>' : '';
                            } 
                            return '' ;
                    }

            }
                
            ],
            
            ajax: url
        });
        
        $('#user_listing').on('page.dt', function () {
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
        $('#user_listing tbody').on('change', 'input[type="checkbox"]', function () {
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
                            deleteUser(ids);
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
        // expert list
        
    }

    
}


function deleteUser(ids) {
    $(".ui-loader-background").show();
    $.ajax({
        type: "POST",
        url: SITE_URL + "/delete-user",
        data: {
            ids: ids
        },
        success: function (response) {
             $(".ui-loader-background").hide();
            if (response.success == true) {
                window.location.href = SITE_URL + '/user-listing';
            } else {
                if (response.message == '') {
                    $.each(response.result, function (key, value) {
                        $('#user_list .alert-danger').append($("<li/>", {
                            text: value
                        }));

                    });
                } else {
                    $('#user_list .alert-danger').html('<li>' + response.message + '</li>');
                }

                $('#user_list .alert-danger').show();



            }

        },
        error: function (request, status, error) {
             $(".ui-loader-background").hide();
             $('#user_list .alert-danger').html('<li>Something went wrong. Please contact Benefit Wellness</li>').show();
        }
    });
    return false;

}
function approveAsExpert(id,user_type) {
    $(".ui-loader-background").show();
    $.ajax({
        type: "POST",
        url: SITE_URL + "/approve",
        data: {
            id: id,
            user_type:user_type
        },
        success: function (response) {
             $(".ui-loader-background").hide();
            if (response.success == true) {
                window.location.href = SITE_URL + '/user-listing';
            } else {
                if (response.message == '') {
                    $.each(response.result, function (key, value) {
                        $('#user_list .alert-danger').append($("<li/>", {
                            text: value
                        }));

                    });
                } else {
                    $('#user_list .alert-danger').html('<li>' + response.message + '</li>');
                }

                $('#user_list .alert-danger').show();



            }

        },
        error: function (request, status, error) {
             $(".ui-loader-background").hide();
             $('#user_list .alert-danger').html('<li>Something went wrong. Please contact Benefit Wellness</li>').show();
        }
    });
    return false;

}
function disapproveAsExpert(id,user_type) {
    $(".ui-loader-background").show();
    $.ajax({
        type: "POST",
        url: SITE_URL + "/disapprove",
        data: {
            id:id,
            user_type:user_type
        },
        success: function (response) {
           $(".ui-loader-background").hide();
            if (response.success == true) {
                window.location.href = SITE_URL + '/user-listing';
            } else {
                if (response.message == '') {
                    $.each(response.result, function (key, value) {
                        $('#user_list .alert-danger').append($("<li/>", {
                            text: value
                        }));

                    });
                } else {
                    $('#user_list .alert-danger').html('<li>' + response.message + '</li>');
                }

                $('#user_list .alert-danger').show();



            }
        },
        error: function (request, status, error) {
           $(".ui-loader-background").hide();
           $('#user_list .alert-danger').html('<li>Something went wrong. Please contact Benefit Wellness</li>').show();
        }
    });
    return false;

}

function change_form_submit() {
    $('#changePasswordModal .alert').hide().html('');

    $(".ui-loader-background").show();
    var formData = new FormData($('#changePswdForm')[0]);
    $.ajax({
        type: "POST",
        url: SITE_URL + "/change-password",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.success == true) {
                $('#changePasswordModal .alert-success').html(response.message).show();
                $('#changePasswordModal .alert-success').delay(1000).fadeOut("normal", function() {
                    $(this).hide().html('');
                    $('#changePasswordModal').modal('hide');
                });
            } else {
                if (response.message == '') {
                    $.each(response.result, function (key, value) {
                        $('#changePasswordModal .alert-danger').append($("<li/>", {
                            text: value
                        }));

                    });
                } else {
                    $('#changePasswordModal .alert-danger').html('<li>' + response.message + '</li>');
                }

                $('#changePasswordModal .alert-danger').show();
            }
        },
        error: function (request, status, error) {
            $('#changePasswordModal .alert-danger').html('<li>Something went wrong. Please contact Benefit Wellness</li>').show();
        }

    });
    $(".ui-loader-background").hide();
    return false;
}

$(document).ready(function () {
    showUserList(0);
    // expert list
    $('.btn-expertList').on('click', function (e) {
        e.preventDefault();
        showUserList(1);
    });
    // end expert list

    /* manage height of date slot box with respect to time slots height */
    $('.time_slot_box .value_text').height();
    $( ".time_slot_box" ).each(function() {
        var height = $(this).find('.value_text').height();
        $(this).find('.label_text').css('height', height+'px');
        $(this).find('.label_text').css('line-height', height+'px');

    });

    /* change password modal */
    $('#changePasswordModal .alert').hide().html('');
    if ($("#changePswdForm").length > 0) {
        var changepwd_form = $("#changePswdForm");
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
    /* end change password modal */
});
