function showList() {

    if ($('#provider_listing').length) {
         var url='';
         url = SITE_URL + '/'+ 'provider-data';
           
        var table;
        table = $('#provider_listing').DataTable({
            bDestroy:true,
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
                },
                 {
                    data: 'website',
                    name: 'website'
                },
                 {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                 {
                    data: 'address',
                    name: 'address'
                },
                 {
                    data: 'delivery',
                    name: 'delivery'
                },
                 {
                    data: 'timings',
                    name: 'timings'
                },
                 {
                    data: 'closing_day',
                    name: 'closing_day'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                }
                
            ],
            
            ajax: url
        });
        
        $('#provider_listing').on('page.dt', function () {
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
        $('#provider_listing tbody').on('change', 'input[type="checkbox"]', function () {
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
        $('.btn-deleteProvider').on('click', function (e) {
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
                            deleteProvider(ids);
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
        $('.btn-editProvider').on('click', function (e) {
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
                openEditProviderPage(ids);
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


function deleteProvider(ids) {
    $(".ui-loader-background").show();
    $.ajax({
        type: "POST",
        url: SITE_URL + "/delete-provider",
        data: {
            ids: ids
        },
        success: function (response) {
             $(".ui-loader-background").hide();
            if (response.success == true) {
                window.location.href = SITE_URL + '/provider-listing';
            } else {
                if (response.message == '') {
                    $.each(response.result, function (key, value) {
                        $('#provider_list .alert-danger').append($("<li/>", {
                            text: value
                        }));

                    });
                } else {
                    $('#provider_list .alert-danger').html('<li>' + response.message + '</li>');
                }

                $('#provider_list .alert-danger').show();



            }

        },
        error: function (request, status, error) {
             $(".ui-loader-background").hide();
             $('#provider_list .alert-danger').html('<li>Something went wrong. Please contact Benefit Wellness</li>').show();
        }
    });
    return false;

}
function openEditProviderPage(id) {
    window.location.href = SITE_URL + '/provider?id=' + id;
}

function save_provider_form_submit() {
    $(".ui-loader-background").show();
    var formData = new FormData($('#save_provider_form')[0]);
    $('#provider_list .alert').hide().html('');

    $.ajax({
        type: "POST",
        url: SITE_URL + "/save-provider",
        data: formData,
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            $(".ui-loader-background").hide();
            if (response.success == true) {
                window.location.href = SITE_URL + '/provider-listing';
            } else {
                if (response.message == '') {
                    $.each(response.result, function (key, value) {
                        $('#provider_list .alert-danger').append($("<li/>", {
                            text: value
                        }));
                    });
                } else {
                    $('#provider_list .alert-danger').html('<li>' + response.message + '</li>');
                }
                $('#provider_list .alert-danger').show();
            }
        },
        error: function (request, status, error) {
            $(".ui-loader-background").hide();
            $('#provider_list .alert-danger').html('<li>Something went wrong. Please contact Benefit Wellness</li>').show();
        }
    });
    return false;
}
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

$(document).ready(function () {
    //$('#provider_list .alert').hide().html('');
    if($("#save_provider_form").length > 0){
         //getLocation();
    }
   
    showList();
    // save insurance
    if ($("#save_provider_form").length > 0) {
        $("#save_provider_form").trigger('reset');

        var save_insurance_form = $("#save_provider_form");
        save_insurance_form.validate({
            errorPlacement: function errorPlacement(error, element) {
                console.log(element[0].name);
                if (element[0].name == "opening_hrs" || element[0].name == "closing_hrs" || element[0].name == "closing_day") {
                    element.parents('.btn-group').after(error);
                } else if(element[0].name == "logo") {
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
                },
                website: {
                    required: true
                },
                email: {
                    required: true
                },
                phone: {
                    required:true
                },
                address: {
                    required:true
                },
                opening_hrs: {
                    required: true
                },
                closing_hrs: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Health provider name is required."
                },
                logo: {
                    required: "Health provider logo is required."
                },
                description: {
                    required: "Health provider description is required."
                },
                website: {
                    required: "Health provider website is required."
                },
                email: {
                    required: "Health provider email is required."
                },
                phone: {
                    required: "Health provider phone is required."
                },
                address: {
                    required: "Health provider address is required."
                },
                
                opening_hrs: {
                    required: "Please select opening hrs."
                },
                closing_hrs: {
                    required: "Please select closing hrs."
                }
            },
            submitHandler: function (form, event) {
                save_provider_form_submit();
            }
        });
        save_insurance_form.validate().settings.ignore = "";
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
