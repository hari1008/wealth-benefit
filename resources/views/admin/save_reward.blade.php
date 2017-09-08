@extends('layouts.app') @section('content')
<div id="page-wrapper">
    <div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
        <div class="page-header pull-left">
            <div class="page-title">Reward</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="page-content" id="reward_list">
       
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
                    <div class="panel-heading">Add Reward</div>
                    <form class="form-horizontal" method="post" id="save_reward_form" name="save_reward_form" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Reward Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="reward_name" placeholder="Enter the reward name " value="{{old('reward_name')? old('reward_name'): (!empty($rewardData['reward_name'])? $rewardData['reward_name']:'') }}">
                                <?php
                                    $rewardId = isset($_GET['id']) ?$_GET['id'] :0;
                                    if($rewardId > 0){
                                        $disabled='';
                                    }else{
                                        $disabled='disabled';
                                    }
                                ?>
                                <input type="hidden" class="form-control" name="master_reward_id" <?php echo $disabled;?> value="{{isset($_GET['id']) ?$_GET['id'] :0 }}" id="master_reward_id">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Reward Description</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="reward_description" placeholder="Enter the reward description " value="{{old('reward_description')? old('reward_description'): (!empty($rewardData['reward_description'])? $rewardData['reward_description']:'') }}">
                            </div>
                        </div>
                        <div class="form-group event_upload_image">
                            <label class="col-sm-4 control-label">Reward Image</label>
                            <div class="col-sm-6 logoGroup">
                                <div class="col-sm-6 mr-t-10 image_sec text-center">
                                    <?php
                                        $logo =  asset('images/venue_default_img.png');
                                        $class = '';
                                        if(!empty($rewardData->reward_image)){
                                            $logo = $rewardData->reward_image;
                                            $class='savedImage';
                                        }
                                         ?>
                                    <img src="{{$logo}}" id="logo1"  class="{{$class}}">
                                </div>
                                <div class="col-sm-6 input_sec">
                                    <span class="upload_btn btn btn-default">Upload Image</span>
                                    
                                    <input type="file" onchange="readURL(this,'logo1');" class="form-control" name="reward_image" id="add_work_image">
                                </div>
                                <div class="error_sec col-sm-12"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Merchant</label>
                            <div class="col-sm-6">
                                <div class="btn-group btn-input custom_select_box clearfix">
                                    <input type="hidden" name="master_merchant_id" value="{{ old('master_merchant_id') ? old('master_merchant_id') : (!empty($rewardData['master_merchant_id']) ? $rewardData['master_merchant_id']:'') }}">
                                    <button id="closing_day" type="button" class="dropdown-toggle form-control" data-toggle="dropdown"><span data-bind="label"><?php echo !empty($rewardData['master_merchant_id']) ? $merchants[$rewardData['master_merchant_id']]  : "Select"?></span></button>
                                    <ul class="dropdown-menu custom_select" role="menu">
                                        <?php
                                        foreach ($merchants as $key => $val) {
                                            echo "<li><a data-val='" . $key . "'>" . $val . "</a></li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
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
<script src="{{asset('js/admin/reward.js')}}"></script>
@stop
