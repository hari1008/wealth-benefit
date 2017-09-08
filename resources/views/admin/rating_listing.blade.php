@extends('layouts.app') @section('content')
<div id="page-wrapper">
    <div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
        <div class="page-header pull-left">
            <div class="page-title">Rating List</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="page-content" id="activation_code">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="" id="rating_list_filter" class="form-horizontal">
                            <div class="col-sm-12">
                                <div class="pull-left">
                                    <div class="form-group">
                                        From:
                                        <input id="fromdatepicker" class="datepicker hasDatepicker" type="text"  value="{{isset($_GET['fromDate']) ?$_GET['fromDate']:date('Y-m-d', strtotime('-7 days')) }}"> To:
                                        <input id="todatepicker" class="datepicker hasDatepicker" type="text"  value="{{isset($_GET['toDate']) ?$_GET['toDate']:date('Y-m-d') }}">
                                        <button class="btn btn-default btn-go" type="submit">Go</button>
                                    </div>
                                </div>
                            </div>
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover select" id="rating_list">
                                    <thead>
                                        <tr>
                                            <th>Wellness Seeker</th>
                                            <th>Expert</th>
                                            <th>Rating</th>
                                            <th>Comment</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </form>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
</div>
<!-- /#page-wrapper -->
@endsection @section('scripts')
<script src="{{asset('js/admin/rating.js')}}"></script>
@stop
