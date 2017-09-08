
@extends('layouts.app') 
@section('content')
<div id="page-wrapper">
    <div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
        <div class="page-header pull-left">
            <div class="page-title">Health Provider</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="page-content" id="provider_list">
        
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
                    <div class="panel-heading">Add Health Provider</div>
                    <form class="form-horizontal" method="post" id="save_provider_form" name="save_provider_form" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Health Provider Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="name" placeholder="Enter the name of health provider" value="{{old('name')? old('name'): (!empty($healthData['name'])? $healthData['name']:'') }}">
                                
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
                            <label class="col-sm-4 control-label">Health Provider Logo</label>
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
                                    
                                    <input type="file" onchange="readURL(this,'logo1');" class="form-control" name="logo" id="add_provider_image">
                                </div>
                                <div class="error_sec col-sm-12"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Description</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="description" placeholder="Enter Description" value="{{old('description')? old('description'): (!empty($healthData['description'])? $healthData['description']:'') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="email" placeholder="Enter Email" value="{{old('email')? old('email'): (!empty($healthData['email'])? $healthData['email']:'') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Website</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="website" placeholder="Enter Website" value="{{old('website')? old('website'): (!empty($healthData['website'])? $healthData['website']:'') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Phone</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="phone" placeholder="Enter Phone" value="{{old('phone')? old('phone'): (!empty($healthData['phone'])? $healthData['phone']:'') }}">
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-4 control-label">Address</label>
                            
                                           
                                           
                            <div class="col-sm-6 location_group">
                                <a data-toggle="modal" data-target="#map_modal">
                                    <input type="text" readonly class="form-control" name="address" placeholder="Choose" id="location" value="{{old('address')? old('address'): (!empty($healthData['address'])? $healthData['address']:'') }}">
                                    <input type="hidden" name="lat" id="lat" value="{{old('lat')? old('lat'): (!empty($healthData['lat'])? $healthData['lat']:'') }}">
                                    <input type="hidden" name="lng" id="lng" value="{{old('lng')? old('lng'): (!empty($healthData['lng'])? $healthData['lng']:'') }}">
                                    <img src="{{asset('images/location.png')}}" class="map_location">
                                  </a>
                            </div>
                                 
                        </div>
                        <?php
                                                            $checkedY = '';
                                                            $checkedN='checked';
                                                           
                                                            if(isset($healthData['delivery']) && $healthData['delivery']==1 ){
                                                                $checkedY = "checked";
                                                                $checkedN='';
                                                            }else if(isset($healthData['delivery']) && $healthData['delivery']==0){
                                                                 $checkedY = "";
                                                                $checkedN='checked';
                                                            }
                                                            
                                                            ?>
                                                            
                                                            @if (old('delivery'))
                                                            <?php
                                                            $delivery = old('delivery');
                                                            if($delivery == 1){
                                                                $checkedY = "checked";
                                                                $checkedN='';
                                                            }else  if($delivery == 0){
                                                                $checkedY = "";
                                                                $checkedN='checked';
                                                                
                                                            }
                                                            ?>
                                                            @endif
                                                            
                         <div class="form-group">
                            <label class="col-sm-4 control-label">Delivery</label>
                            <div class="col-sm-6">
                               <div class="radio-inline">
                                <input class="radio-custom" name="delivery" type="radio" value="1" {{$checkedY}} >
                                <label for="delivery" class="radio-custom-label">Yes</label>
                            </div>
                            <div class="radio-inline">
                                <input class="radio-custom" name="delivery" type="radio" value="0" {{$checkedN}}>
                                <label for="delivery" class="radio-custom-label ">No</label>
                            </div> 
                            </div>
                        </div>
                        <div class="form-group">
                                    <label class="col-sm-4 control-label">Closing Day</label>
                                    <?php
                                     $weekDay = Config::get('constants.weekDay');
                                    ?>
                                    <div class="col-sm-6">
                                        <div class="btn-group btn-input custom_select_box clearfix">
                                            <input type="hidden" name="closing_day" value="{{ old('closing_day') ? old('closing_day') : (!empty($healthData['closing_day']) ? $healthData['closing_day']:'') }}">
                                            <button id="closing_day" type="button" class="dropdown-toggle form-control" data-toggle="dropdown"><span data-bind="label"><?php echo !empty($healthData['closing_day']) ? $weekDay[$healthData['closing_day']]  : "None"?></span></button>
                                            <ul class="dropdown-menu custom_select" role="menu">
                                                 <li><a data-val="">None</li>
                                                <?php
                                               
                                                
                                                foreach ($weekArray as $key => $val) {
                                                   
                                                    echo "<li><a data-val='" . $val . "'>" . $key . "</a></li>";
                                                }
                                                ?>
                                               
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-4 control-label">Timings</label>
                                    <div class="col-sm-6">
                                        <div class="col-sm-6 pd-l0">
                                            <div class="btn-group btn-input custom_select_box clearfix">
                                                <input type="hidden" name="opening_hrs" value="{{ old('opening_hrs') ? old('opening_hrs') : (!empty($healthData['opening_hrs']) ? $healthData['opening_hrs']:'') }}" >
                                                <button id="opening_hrs" type="button" class="dropdown-toggle form-control" data-toggle="dropdown"><span data-bind="label"><?php echo !empty($healthData['opening_hrs']) ? $healthData['opening_hrs']  : "Select"?></span></button>
                                                <ul class="dropdown-menu custom_select" role="menu">
                                                    <?php
                                                    foreach ($timings as $key => $val) {
                                                        echo "<li><a data-val='" . $val . "'>" . $key . "</a></li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pd-r0">
                                            <div class="btn-group btn-input custom_select_box clearfix">
                                                <input type="hidden" name="closing_hrs" value="{{ old('closing_hrs') ? old('closing_hrs') : (!empty($healthData['closing_hrs']) ? $healthData['closing_hrs']:'') }}">
                                                <button id="closing_hrs" type="button" class="dropdown-toggle form-control" data-toggle="dropdown"><span data-bind="label"><?php echo !empty($healthData['closing_hrs']) ? $healthData['closing_hrs']  : "Select"?></span></button>
                                                <ul class="dropdown-menu custom_select" role="menu">
                                                    <?php
                                                    foreach ($timings as $key => $val) {
                                                        echo "<li><a data-val='" . $val . "'>" . $key . "</a></li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
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

@include('admin.map')
<!-- /#page-wrapper -->
@endsection 
@section('scripts')
<script src="{{asset('js/admin/provider.js')}}" type="text/javascript"></script>
@stop
