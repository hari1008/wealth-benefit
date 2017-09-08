function showList() {

    if ($('#reported_issue').length) {
         var url='';
         url = SITE_URL + '/'+ 'reported-issue-data';
           
        var table;
        table = $('#reported_issue').DataTable({
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
                    data: 'user_id',
                    name: 'user_id'
                },
                {
                    data: 'issue_id',
                    name: 'issue_id'
                },
               
                 {
                    data: 'description',
                    name: 'description'
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


$(document).ready(function () {
  showList();
 
  
}); 