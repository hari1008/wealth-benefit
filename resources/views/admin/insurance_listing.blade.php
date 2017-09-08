@extends('layouts.app') @section('content')
<div id="page-wrapper">
    <div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
        <div class="page-header pull-left">
            <div class="page-title">Health Insurance List</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="page-content" id="insurance_list">
        @if (session('success-message'))
        <div class="alert alert-success">
            <?php
                $error = session('success-message');
                echo $error;
                \App\Helper\Utility\UtilityHelper::forgetSession('success-message');
            ?>
        </div>
        @endIf
        <div class="alert alert-danger text-left hiddenEle"></div>
        <div class="alert alert-success text-left hiddenEle"></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <div class="form-group">
                                <a class="btn btn-default btn-addProvider" href="{{URL::to('insurance')}}"><i class="fa fa-plus-square"></i>Add Insurance</a>
                                <button class="btn btn-default btn-deleteInsurance" type="button"><i class="fa fa-trash"></i>Delete</button>
                                <button class="btn btn-default btn-editInsurance" type="button"><i class="fa fa-edit"></i>Edit Insurance</button>
                            </div>
                            <table class="table table-striped table-bordered table-hover select" id="insurance_listing">
                                <thead>
                                    <tr>
                                        <th>
                                            <input name="select_all" value="1" id="code-select-all" type="checkbox">
                                        </th>
                                        <th>Logo</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Created Date</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
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
<script src="{{asset('js/admin/insurance.js')}}"></script>
@stop
