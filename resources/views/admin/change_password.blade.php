@extends('layouts.app') @section('content')
<div id="page-wrapper">
    <div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
        <div class="page-header pull-left">
            <div class="page-title">Change Password</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="page-content" id="change_password">
        <div class="alert alert-danger text-left"> </div>
        <div class="alert alert-success text-left"> </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <form id="change_pswd_form" class="form-horizontal" name="change_pswd_form" action="" method="POST">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Old Password</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" name="oldPassword" id="oldPassword" value="{{old('oldPassword')? old('oldPassword'):''}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">New Password</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" name="newPassword" id="newPassword" value="{{old('newPassword')? old('newPassword'):''}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Retype New Password</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" value="{{old('confirmPassword')? old('confirmPassword'):''}}">
                                    </div>
                                </div>
                                <div class="form-group right-form-btn">
                                    <div class="col-sm-offset-4 col-sm-6">
                                        <button type="submit" class="btn btn_default" id="chng-pass">Change password</button>
                                    </div>
                                </div>
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
<script src="{{asset('js/admin/change_password.js')}}"></script>
@stop
