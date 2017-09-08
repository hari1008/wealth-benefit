@extends('layouts.app') @section('content')
<div id="page-wrapper">
    <div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
        <div class="page-header pull-left">
            <div class="page-title">Merchant</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="page-content" id="work_list">
       
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
            <div class="col-sm-12 col-md-12">
                <div class="form_inner event_det panel panel-violet">
                    <div class="panel-heading">Add Merchant</div>
                    <form class="form-horizontal" method="post" id="save_merchant_form" name="save_merchant_form" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Merchant Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="merchant_name" placeholder="Enter the merchant name " value="{{old('merchant_name')? old('merchant_name'): (!empty($merchantData['merchant_name'])? $merchantData['merchant_name']:'') }}">
                                <?php
                                    $merchantId = isset($_GET['id']) ?$_GET['id'] :0;
                                    if($merchantId > 0){
                                        $disabled='';
                                    }else{
                                        $disabled='disabled';
                                    }
                                ?>
                                <input type="hidden" class="form-control" name="master_merchant_id" <?php echo $disabled;?> value="{{isset($_GET['id']) ?$_GET['id'] :0 }}" id="master_merchant_id">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-6 col-sm-4">
                                <button type="submit" class="btn btn-default">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
</div>
<!-- /#page-wrapper -->
@endsection @section('scripts')
<script src="{{asset('js/admin/merchant.js')}}"></script>
@stop
