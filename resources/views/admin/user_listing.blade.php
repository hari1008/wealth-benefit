@extends('layouts.app') @section('content')
<div id="page-wrapper">
    <div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
        <div class="page-header pull-left">
            <div class="page-title">Wellness Seekers</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="page-content" id="user_list">
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
                                <button class="btn btn-default btn-deleteCodes" type="button"><i class="fa fa-trash"></i>Delete</button>
                                <button class="btn btn-default btn-expertList" type="button"><i class="fa fa-th-list fa-fw"></i>Expert List</button>
                            </div>
                            <table class="table table-striped table-bordered table-hover select" id="user_listing">
                                <thead>
                                    <tr>
                                        <th>
                                            <input name="select_all" value="1" id="code-select-all" type="checkbox">
                                        </th>
                                        <th>Image</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>User Type</th>
                                        <th>Ecosystem</th>
                                        <th>Type of Expert</th>
                                        <th class="no-sort">Action</th>
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
<!-- Modal -->
<div id="changePasswordModal" class="modal fade in" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">Change Password</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger text-left"> </div>
                <div class="alert alert-success text-left"> </div>
                <form id="changePswdForm" class="form-horizontal" name="change_pswd_form" action="" method="POST">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="password" class="form-control" name="oldPassword" id="oldPassword" placeholder="Type your password..">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="Type new password..">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Retype new password..">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-default" id="chnangePasswordBtn">Change password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<?php
if(Auth::User()->is_password_changed == 1){?>
<script>
    $(document).ready(function () {
       $('#changePasswordModal').modal({
           backdrop: 'static',
           keyboard: false
       });
       $('.modal-backdrop').css('opacity', '1');
    });
    </script>
    <?php
}?>

<script src="{{asset('js/admin/user_listing.js')}}"></script>
@stop


