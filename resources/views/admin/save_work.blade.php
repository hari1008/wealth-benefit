@extends('layouts.app') @section('content')
<div id="page-wrapper">
    <div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
        <div class="page-header pull-left">
            <div class="page-title">Work</div>
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
                    <div class="panel-heading">Add Work</div>
                    <form class="form-horizontal" method="post" id="save_work_form" name="save_work_form" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Work Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="work_name" placeholder="Enter the work name " value="{{old('name')? old('name'): (!empty($workData['work_name'])? $workData['work_name']:'') }}">
                                <?php
                                    $workId = isset($_GET['id']) ?$_GET['id'] :0;
                                    if($workId > 0){
                                        $disabled='';
                                    }else{
                                        $disabled='disabled';
                                    }
                                ?>
                                <input type="hidden" class="form-control" name="work_id" <?php echo $disabled;?> value="{{isset($_GET['id']) ?$_GET['id'] :0 }}" id="work_id">
                            </div>
                        </div>
                        <div class="form-group event_upload_image">
                            <label class="col-sm-4 control-label">Work Logo</label>
                            <div class="col-sm-6 logoGroup">
                                <div class="col-sm-6 mr-t-10 image_sec text-center">
                                    <?php
                                        $logo =  asset('images/venue_default_img.png');
                                        $class = '';
                                        if(!empty($workData->logo)){
                                            $logo = $workData->logo;
                                            $class='savedImage';
                                        }
                                         ?>
                                    <img src="{{$logo}}" id="logo1"  class="{{$class}}">
                                </div>
                                <div class="col-sm-6 input_sec">
                                    <span class="upload_btn btn btn-default">Upload Image</span>
                                    
                                    <input type="file" onchange="readURL(this,'logo1');" class="form-control" name="logo" id="add_work_image">
                                </div>
                                <div class="error_sec col-sm-12"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Type</label>
                            <?php
                             $workType = Config::get('constants.work_type');
                            ?>
                            <div class="col-sm-6">
                                <div class="btn-group btn-input custom_select_box clearfix">
                                    <input type="hidden" name="type" value="{{ old('type') ? old('type') : (!empty($workData['type']) ? $workData['type']:'') }}">
                                    <button id="closing_day" type="button" class="dropdown-toggle form-control" data-toggle="dropdown"><span data-bind="label"><?php echo !empty($workData['type']) ? $workType[$workData['type']]  : "Select"?></span></button>
                                    <ul class="dropdown-menu custom_select" role="menu">
                                        <?php
                                        foreach ($workType as $key => $val) {
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
<script src="{{asset('js/admin/work.js')}}"></script>
@stop
