@extends('layouts.app') @section('content')
<div id="page-wrapper">
    <div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
        <div class="page-header pull-left">
            <div class="page-title">Settings</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="page-content" id="terms_list">
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
                    <div class="panel-body">
                        <form action="" id="terms_condition_form" class="form-horizontal" method="POST">
                          
                            <!--<div class="dataTable_wrapper">
                             <textarea id="description" name="description" rows="2" cols="20">{{$description}}</textarea>
                             <input type="text" name="introductory" value="" />
                             <input type="button" value="Save" name="save" id="save" onclick="saveTermsCondition()"/>
                            </div>-->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Terms and conditions</label>
                                <div class="col-sm-9">
                                    <div class="dataTable_wrapper">
                                        <textarea id="description" name="description" rows="2" cols="20">{{$description}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Introductory Session Price</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="introductory" name="introductory" value="{{$introductory}}">
                                </div>
                            </div>
                            <div class="form-group right-form-btn">
                                <div class="col-sm-offset-4 col-sm-6">
                                    <input type="button" value="Save" name="save" id="save" onclick="saveTermsCondition()"/>
                                </div>
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
<script src="{{asset('js/tinymce/js/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('js/admin/add_terms_condition.js')}}"></script>

  
@stop
