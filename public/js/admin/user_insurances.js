function showList() {

    if ($('#table_insurance_interest_list').length) {
        var toDate = $("#todatepicker").val();
        var fromDate = $("#fromdatepicker").val();
        var url = '';
        url = SITE_URL + '/' + 'user-insurance-data?toDate='+toDate+'&fromDate='+fromDate;
        var table;
        table = $('#table_insurance_interest_list').DataTable({
            bDestroy: true,
            bFilter: false,
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
                    data: 'user_id',
                    name: 'user_id'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'attribute_id',
                    name: 'attribute_id'
                },
                {
                    data: 'text',
                    name: 'text'
                },
               
                {
                    data: 'created_at',
                    name: 'created_at'
                }
            ],
            ajax: url
        });
    }
}

  var url='';
$(document).ready(function () {
    
    
     showList();
     $('.btn-go').on('click', function (e) {
         e.preventDefault();
          showList();
     });
     

    /* Bootstrap Datetimepicker */
    if($('#fromdatepicker').length >0){
        var curr_date = new moment().format('YYYY MM DD');
        $('#fromdatepicker').datetimepicker({
            format: 'YYYY-MM-DD',
            showClear: true,
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                clear: "fa fa-trash",
                next: "fa fa-arrow-right",
                previous: "fa fa-arrow-left"
            },
            useCurrent: true
        });
        $('#fromdatepicker input').click(function(event){
            $('#fromdatepicker ').data("DateTimePicker").toggle();
        });

    }
    if($('#todatepicker').length >0){
        $('#todatepicker').datetimepicker({
            format: 'YYYY-MM-DD',
            showClear: true,
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                clear: "fa fa-trash",
                next: "fa fa-arrow-right",
                previous: "fa fa-arrow-left"
            },
            useCurrent: true,
        });
        $('#todatepicker input').click(function(event){
            $('#todatepicker ').data("DateTimePicker").toggle();
        });
    }
    /* End Bootstrap Datetimepicker */

});
