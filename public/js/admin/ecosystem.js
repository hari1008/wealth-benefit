$('.benefit-datepicker').datepicker();
function showList() {

    if ($('#ecosystem_listing').length) {
        var url = '';
        url = SITE_URL + '/' + 'ecosystem-data';

        var table;
        table = $('#ecosystem_listing').DataTable({
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
                    data: 'ecosystem_id',
                    name: 'ecosystem_id',
                   render: function (data, type, row) {
                        return    '<input type="checkbox" value= "'+row.ecosystem_id+'" name=id[] />';
                    }
                },
                {
                    data: 'ecosystem_name',
                    name: 'ecosystem_name',
                },
                {
                    data: 'number_of_users',
                    name: 'number_of_users'
                },

                {
                    data: 'expiry_date',
                    name: 'expiry_date'
                }, 
                {
                    data: 'created_at',
                    name: 'created_at'
                }, 
                {
                    data: 'ecosystem_id',
                    name: 'ecosystem_id',
                    render: function (data, type, row) {
                        if (row.deleted_at) {
                                      return '<a title= "Activation Codes" href= "javascript:void(0)" onClick="viewActivationCode('+row.ecosystem_id+')" class=""><i class="fa fa-qrcode"></i></a>&nbsp;<a title= "Activate" href= "javascript:void(0)" onClick="changeEcosystemStatus('+row.ecosystem_id+')" class=""><i class="fa fa-check-square-o"></i></a>';
                                  }
                              else{
                                      return '<a title= "Activation Codes" href= "javascript:void(0)" onClick="viewActivationCode('+row.ecosystem_id+')" class=""><i class="fa fa-qrcode"></i></a>&nbsp;<a title= "Deactivate" href= "javascript:void(0)" onClick="changeEcosystemStatus('+row.ecosystem_id+')" class=""><i class="fa fa-times-circle"></i></a>' ;
                              } 
                    }
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
        $('.btn-deleteEcosystem').on('click', function (e) {
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
                            deleteEcosystem(ids);
                        }
                    }
                });
            } else {
                BootstrapDialog.show({
                    title: 'Alert',
                    closable: false,
                    message: 'Please select one record?',
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
        $('.btn-editEcosystem').on('click', function (e) {
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
                openEditEcosystemPage(ids);
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


function deleteEcosystem(ids) {
    
    $(".ui-loader-background").show();
    
    $.ajax({
        type: "POST",
        url: SITE_URL + "/delete-ecosystem",
        data: {
            ids: ids
        },
        success: function (response) {
            $(".ui-loader-background").hide();
            if (response.success == true) {
                window.location.href = SITE_URL + '/ecosystem-listing';
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

function changeEcosystemStatus(ids){
    $(".ui-loader-background").show();
    
    $.ajax({
        type: "POST",
        url: SITE_URL + "/ecosystem-change-status",
        data: {
            ids: ids
        },
        success: function (response) {
            console.log(response);
            $(".ui-loader-background").hide();
            if (response.success == true) {
                window.location.href = SITE_URL + '/ecosystem-listing';
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

function openEditEcosystemPage(id) {
    window.location.href = SITE_URL + '/ecosystem?id=' + id;
}

function viewActivationCode(id) {
    window.location.href = SITE_URL + '/code-listing/' + id;
}

function save_ecosystem_form_submit() {
    $(".ui-loader-background").show();
    var formData = new FormData($('#save_ecosystem_form')[0]);
    $('#ecosystem_list .alert').hide().html('');

    $.ajax({
        type: "POST",
        url: SITE_URL + "/save-ecosystem",
        data: formData,
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            $(".ui-loader-background").hide();
            console.log(response);
            if (response.success == true) {
                window.location.href = SITE_URL + '/ecosystem-listing';
            } else {
                if (response.message == '') {
                    $.each(response.result, function (key, value) {
                        $('#ecosystem_list .alert-danger').append($("<li/>", {
                            text: value
                        }));
                    });
                } else {
                    $('#ecosystem_list .alert-danger').html('<li>' + response.message + '</li>');
                }
                $('#ecosystem_list .alert-danger').show();
            }
        },
        error: function (request, status, error) {
            $(".ui-loader-background").hide();
            $('#ecosystem_list .alert-danger').html('<li>Something went wrong. Please contact Benefit Wellness</li>').show();
        }
    });
    return false;
}

$(document).ready(function () {
    showList();
    // save insurance
    if ($("#save_ecosystem_form").length > 0) {
        $("#save_ecosystem_form").trigger('reset');

        var save_ecosystem_form = $("#save_ecosystem_form");
        save_ecosystem_form.validate({
            errorPlacement: function errorPlacement(error, element) {
                if(element[0].name == "logo") {
                    element.parents('.logoGroup').append(error);
                } else {
                    element.after(error);
                }
            },
            rules: {
                ecosystem_name: {
                    required: true
                },
                number_of_users: {
                    required: true
                },
                expiry_date: {
                    required: true
                }
            },
            messages: {
                ecosystem_name: {
                    required: "Ecosystem name is required."
                },
                number_of_users: {
                    required: "Number of users in ecosystem is required."
                },
                expiry_date: {
                    required: "Expiry of ecosystem is required."
                }
            },
            submitHandler: function (form, event) {
                save_ecosystem_form_submit();
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
    
    $(document.body).on('click', '.merchant-class.dropdown-menu li', function (event) {
        var $target = $(event.currentTarget);
        var ele = $(this);
        var eleclass = ele.attr('class');
        $merchant_id = ele.find('a').attr('data-val');
        ele.parents('.custom_select').find('li').removeClass('active');
        ele.addClass('active');
        if(eleclass !== 'active') {
            console.log('test');
            $.ajax({
                type: "get",
                url: SITE_URL+'/find-reward-by-merchant',
                data: { id : $merchant_id},
                success: function (response) {
                    $(".ui-loader-background").hide();
                    if (response.success == true) {
                        html = "";
                        obj = response.result
                        for(var key in obj) {
                            html += "<li><a data-val='" + key  + "'>" +obj[key] + "</a></li>"
                        }
                        ele.parents('.beacon-group').find('.reward-list-class input[type="hidden"]').val('');
                        ele.parents('.beacon-group').find('.reward-list-class [data-bind="label"]').text('Select');
                        ele.parents('.beacon-group').find('.reward-list-class .dropdown-menu').html(html);
                    } else {
                        if (response.message == '') {
                            $.each(response.result, function (key, value) {
                                $('#ecosystem_list .alert-danger').append($("<li/>", {
                                    text: value
                                }));
                            });
                        } else {
                            $('#ecosystem_list .alert-danger').html('<li>' + response.message + '</li>');
                        }
                        $('#ecosystem_list .alert-danger').show();
                    }
                },
                error: function (request, status, error) {
                    $(".ui-loader-background").hide();
                    $('#ecosystem_list .alert-danger').html('<li>Something went wrong. Please contact Benefit Wellness</li>').show();
                }
            });
        }
        return false;
    });
    /* End Custom single select dropdown */
    
    
    var cloneBeacon = function(){
            $clone =  $(".beacon-group:last").clone();
            $clone.find('input').each(function() {
                var currentNameAttr = $(this).attr('name'); 
                $preIndex = currentNameAttr.match(/\d+/)[0];      
                $accessory_body_index = parseInt($preIndex) + 1;
                $(this).attr('name', currentNameAttr.replace($preIndex,$accessory_body_index));   // set the incremented name attribute 
            });
            $(".beacon-grp").append($clone);
//        $(".beacon-group").append('<div class=beacon-grp><div class=row><div class=col-sm-4><div class=form-group2><input class=form-control name=website_link></div></div><div class=col-sm-4><div class=form-group2><input class=form-control name=website_link></div></div><div class=col-sm-4><div class=form-group2><input class=form-control name=website_link></div></div></div><div class="del-beacon">&times;</div></div>');
      }

      $('#add-beacon-btn').on('click', function() {
            cloneBeacon();
      });
      
      $('body').on('click', '.del-beacon', function() {
          if($('.beacon-grp').children().length != 1){
            $(this).parent('.beacon-group').remove();
          }
      });
      
});
