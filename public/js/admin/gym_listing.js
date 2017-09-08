function showList() {
    if ($('#gym_listing').length) {
        var url = '';
        url = SITE_URL + '/' + 'gym-data';

        var table;
        table = $('#gym_listing').DataTable({
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
                    data: 'master_gym_id',
                    name: 'master_gym_id',
                   render: function (data, type, row) {
                        return    '<input type="checkbox" value= "'+row.master_gym_id+'" name=id[] />';
                    }
                },
                {
                    data: 'gym_name',
                    name: 'gym_name',
                },
                {
                    data: 'gym_address',
                    name: 'gym_address'
                },

                {
                    data: 'zip_code',
                    name: 'zip_code',
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
        $('.btn-deleteGym').on('click', function (e) {
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
                            deleteGym(ids);
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


function deleteGym(ids) {
    
    $(".ui-loader-background").show();
    
    $.ajax({
        type: "POST",
        url: SITE_URL + "/delete-gym",
        data: {
            ids: ids
        },
        success: function (response) {
            $(".ui-loader-background").hide();
            if (response.success == true) {
                window.location.href = SITE_URL + '/gym-listing';
            } else {
                if (response.message == '') {
                    $.each(response.result, function (key, value) {
                        $('#gym_list .alert-danger').append($("<li/>", {
                            text: value
                        }));

                    });
                } else {
                    $('#gym_list .alert-danger').html('<li>' + response.message + '</li>');
                }

                $('#gym_list .alert-danger').show();

            }

        },
        error: function (request, status, error) {
            $(".ui-loader-background").hide();
            $('#gym_list .alert-danger').html('<li>Something went wrong. Please contact Benefit Wellness</li>').show();
        }
    });
    return false;

}

function openEditWorkPage(id) {
    window.location.href = SITE_URL + '/gym?id=' + id;
}

function save_gym_form_submit() {
    $(".ui-loader-background").show();
    var formData = new FormData($('#save_gym_form')[0]);
    console.log(formData);
    $('#work_list .alert').hide().html('');

    $.ajax({
        type: "POST",
        url: SITE_URL + "/save-gym",
        data: formData,
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            $(".ui-loader-background").hide();
            if (response.success == true) {
                window.location.href = SITE_URL + '/gym-listing';
            } else {
                if (response.message == '') {
                    $.each(response.result, function (key, value) {
                        $('#gym_list .alert-danger').append($("<li/>", {
                            text: value
                        }));
                    });
                } else {
                    $('#gym_list .alert-danger').html('<li>' + response.message + '</li>');
                }
                $('#gym_list .alert-danger').show();
            }
        },
        error: function (request, status, error) {
            $(".ui-loader-background").hide();
            $('#gym_list .alert-danger').html('<li>Something went wrong. Please contact Benefit Wellness</li>').show();
        }
    });
    return false;
}

$(document).ready(function () {
    showList();
    // save gym
    if ($("#save_gym_form").length > 0) {
        
        $("#save_gym_form").trigger('reset');

        var save_gym_form = $("#save_gym_form");
        save_gym_form.validate({
            errorPlacement: function errorPlacement(error, element) {
                if(element[0].name == "logo") {
                    element.parents('.logoGroup').append(error);
                } else {
                    element.after(error);
                }
            },
            rules: {
                gym_name: {
                    required: true
                },
                gym_address: {
                    required: true
                },
                zip_code: {
                    required: true
                },
                master_work_id: {
                    required: true
                }
            },
            messages: {
                gym_name: {
                    required: "Gym name is required."
                },
                gym_address: {
                    required: "Street Address of Gym is required."
                },
                zip_code: {
                    required: "Zip Code of Gym is required."
                },
                master_work_id: {
                    required: "Gym Group of Gym is required."
                }
            },
            submitHandler: function (form, event) {
                save_gym_form_submit();
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
    
    /* Call Map on modal open */
    $('#map_modal').on('shown.bs.modal', function () {
        initMap();
    });
    
   /* set location from map done */
    $('#map_modal #set_location').on('click', function (e) {
        e.preventDefault();
        var ele = $(this);
        var lat = $('#modal_lat').val();
        var lng = $('#modal_lng').val();
        var address = $('#pac-input').val();
        $('.location_group #location').val(address);
        $('.location_group #lat').val(lat);
        $('.location_group #lng').val(lng);
        $('#map_modal').modal('hide');
        $('#location').valid();
    });
    /* End set location from map done */ 
    
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
