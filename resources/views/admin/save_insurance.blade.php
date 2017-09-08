@extends('layouts.app') @section('content')
<div id="page-wrapper">
    <div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
        <div class="page-header pull-left">
            <div class="page-title">Health Insurance</div>
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
            <div class="col-sm-12 col-md-12">
                <div class="form_inner event_det panel panel-violet">
                    <div class="panel-heading">Add Health Insurance</div>
                    <form class="form-horizontal" method="post" id="save_insurance_form" name="save_insurance_form" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Health Insurance Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="name" placeholder="Enter the name of health insurance" value="{{old('name')? old('name'): (!empty($healthData['name'])? $healthData['name']:'') }}">
                                <?php
                                    $attributeId = isset($_GET['id']) ?$_GET['id'] :0;
                                    if($attributeId > 0){
                                        $disabled='';
                                    }else{
                                        $disabled='disabled';
                                    }
                                ?>
                                <input type="hidden" class="form-control" name="attribute_id" <?php echo $disabled;?> value="{{isset($_GET['id']) ?$_GET['id'] :0 }}" id="attribute_id">
                            </div>
                        </div>
                        <div class="form-group event_upload_image">
                            <label class="col-sm-4 control-label">Health Insurance Logo</label>
                            <div class="col-sm-6 logoGroup">
                                <div class="col-sm-6 mr-t-10 image_sec text-center">
                                    <?php
                                        $logo =  asset('images/venue_default_img.png');
                                        $class = '';
                                        if(!empty($healthData->logo)){
                                            $logo = $healthData->logo;
                                            $class='savedImage';
                                        }
                                         ?>
                                    <img src="{{$logo}}" id="logo1"  class="{{$class}}">
                                </div>
                                <div class="col-sm-6 input_sec">
                                    <span class="upload_btn btn btn-default">Upload Image</span>
                                    
                                    <input type="file" onchange="readURL(this,'logo1');" class="form-control" name="logo" id="add_insurance_image">
                                </div>
                                <div class="error_sec col-sm-12"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Website</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="website" placeholder="Enter Website" value="{{old('website')? old('website'): (!empty($healthData['website'])? $healthData['website']:'') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Description</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="description" placeholder="Enter Description" value="{{old('description')? old('description'): (!empty($healthData['description'])? $healthData['description']:'') }}">
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
<script src="{{asset('js/admin/insurance.js')}}"></script>
@stop
