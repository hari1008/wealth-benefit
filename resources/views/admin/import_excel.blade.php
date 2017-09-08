@extends('layouts.app') @section('content')


<div id="page-wrapper">
    <div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
        <div class="page-header pull-left">
            <div class="page-title">Import Excel</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="page-content" id="importcsv">
        <div class="alert alert-danger text-left scrollDiv"></div>
        <div class="alert alert-success text-left"></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <form id="importform" name="importform" action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                                <input type="file" class="import_input" name="import_file" />
                                <input type="hidden" class="import_input" name="ecosystemId" value="{{$id}}" />
                                <button type="button" class="btn btn-default import_btn" id="import" onclick="importFile();">Import</button>
                            </form>
                        </div>
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
<script src="{{asset('js/admin/import.js')}}"></script>
@stop
