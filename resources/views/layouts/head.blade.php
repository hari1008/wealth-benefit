<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
<meta name="csrf-token" content="{{ csrf_token() }}"> 
<meta http-equiv="refresh" content="900">
<meta name="description" content="">
<meta name="author" content="">
<title>Benefit Wellness</title>
<link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
<!-- Bootstrap Core CSS -->

<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
<!-- MetisMenu CSS -->
<link href="{{asset('css/metisMenu.min.css')}}" rel="stylesheet" type="text/css">
<!-- DataTables CSS -->
<link href="{{asset('css/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css">
<!-- DataTables Responsive CSS -->
<link href="{{asset('css/dataTables.responsive.css')}}" rel="stylesheet" type="text/css">
<!-- Custom CSS -->
<link href="{{asset('css/sb-admin-2.css')}}" rel="stylesheet" type="text/css">
<!-- Custom Fonts -->
<link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/bootstrap-dialog.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/datepicker.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css">
<link rel="shortcut icon" type="image/png" href="{{asset('images/favicon.ico')}}" />
<script src="{{asset('js/jquery.min.js')}}" type="text/javascript"></script>
<script>
     var current_lat = '', current_lng = '';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
//    var SITE_URL = {
//        !!json_encode(url('/')) !!
//    };
    var SITE_URL = {!! json_encode(url('/')) !!};
</script>
<script type="text/javascript">
        function noBack()
         {
             window.history.forward()
         }
        noBack();
        window.onload = noBack;
        window.onpageshow = function(evt) { if (evt.persisted) noBack() }
        window.onunload = function() { void (0) }
    </script>
@yield('styles')
