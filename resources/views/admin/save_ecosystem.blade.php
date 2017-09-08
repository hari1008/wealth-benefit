@extends('layouts.app') @section('content')
<div id="page-wrapper">
    <div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
        <div class="page-header pull-left">
            <div class="page-title">Ecosystem</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="page-content" id="ecosystem_list">
       
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
                    <div class="panel-heading">Add Ecosystem</div>
                    <form class="form-horizontal" method="post" id="save_ecosystem_form" name="save_ecosystem_form" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Ecosystem Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="ecosystem_name" placeholder="Enter the ecosystem name " value="{{old('name')? old('name'): (!empty($ecosystemData['ecosystem_name'])? $ecosystemData['ecosystem_name']:'') }}">
                                <?php
                                    $ecosystemId = isset($_GET['id']) ?$_GET['id'] :0;
                                    if($ecosystemId > 0){
                                        $disabled='';
                                    }else{
                                        $disabled='disabled';
                                    }
                                ?>
                                <input type="hidden" class="form-control" name="ecosystem_id" <?php echo $disabled;?> value="{{isset($_GET['id']) ?$_GET['id'] :0 }}" id="ecosystem_id">
                            </div>
                        </div>
                        <div class="form-group">
                            <?php
                                $allFeatures = [];
                            
                                if(!empty($ecosystemData)):
                                    $allFeatures = $ecosystemData->features()->pluck('ecosystem_features.feature_id','ecosystem_feature_id')->toArray();   
                                endif;
                            ?>
                            <label class="col-sm-4 control-label">Features List</label>
                            <div class="col-sm-6">
                                @foreach ( $features as $id => $name )
                                <div class="checkbox">
                                    <label><input name='features[]' type="checkbox" @if(in_array($id,$allFeatures)) {{ 'checked' }} @endif value="{{$id}}">{{$name}}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <?php
                                $allGyms = [];
                                if(!empty($ecosystemData)):
                                    $allGyms = $ecosystemData->gyms()->pluck('ecosystem_works.work_id','ecosystem_feature_id')->toArray();   
                                endif
                            ?>    
                            <label class="col-sm-4 control-label">Gyms List</label>
                            <div class="col-sm-6">
                                @foreach ( $works as $id => $name )
                                <div class="checkbox">
                                    <label><input name='gyms[]' type="checkbox" @if(in_array($id,$allGyms)) {{ 'checked' }} @endif value="{{$id}}">{{$name}}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group event_upload_image">
                            <label class="col-sm-4 control-label">Ecosystem Logo</label>
                            <div class="col-sm-6 logoGroup">
                                <div class="col-sm-6 mr-t-10 image_sec text-center">
                                    <?php
                                        $logo =  asset('images/venue_default_img.png');
                                        $class = '';
                                        if(!empty($ecosystemData->logo)){
                                            $logo = $ecosystemData->logo;
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
                            <label class="col-sm-4 control-label">Number of Users</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="number_of_users" placeholder="Enter the number of users of the ecosystem" value="{{old('number_of_users')? old('number_of_users'): (!empty($ecosystemData['number_of_users'])? $ecosystemData['number_of_users']:'') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Expiry Date</label>
                            <div class="col-sm-6">
                                <input type="text" data-date-format="yyyy-mm-dd" class="form-control benefit-datepicker" name="expiry_date" placeholder="Enter the expiry date" value="{{old('expiry_date')? old('expiry_date'): (!empty($ecosystemData['expiry_date'])? $ecosystemData['expiry_date']:'') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email of Subadmin</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="email" placeholder="Enter the email id for the sub admin" value="{{old('email')? old('email'): (!empty($ecosystemData['subadmin']['email'])? $ecosystemData['subadmin']['email']:'') }}">
                            </div>
                        </div>
                        <div>
                            <label class="col-sm-4 control-label">Rewards</label>
                                <div class="col-sm-6 beacon-grp">
                                    @php if($ecosystemId > 0 && !empty($ecosystemData['rewards'][0])): 
                                    $i = 0;
                                    foreach($ecosystemData['rewards'] as $reward): @endphp 
                                        <div class="beacon-group">  
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="btn-group btn-input custom_select_box clearfix">
                                                        <label class="control-label">Merchants</label>
                                                        <input type="hidden" name="rewards[{{$i}}][master_merchant_id]" class="" value="{{ old('master_merchant_id') ? old('master_merchant_id') : (!empty($reward['master_merchant_id']) ? $reward['master_merchant_id']:'') }}">
                                                        <button id="master_merchant_id" type="button" class="dropdown-toggle form-control" data-toggle="dropdown"><span data-bind="label"><?php echo !empty($reward['master_merchant_id']) ? (!empty($merchants[$reward['master_merchant_id']])? $merchants[$reward['master_merchant_id']] :"Select") : "Select"?></span></button>
                                                        <ul class="dropdown-menu custom_select merchant-class" role="menu">
                                                            <?php
                                                            foreach ($merchants as $key => $value) {
                                                                echo "<li><a data-val='" . $key . "'>" . $value . "</a></li>";
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="btn-group btn-input custom_select_box reward-list-class clearfix">
                                                        <label class="control-label">Rewards</label>
                                                        <input type="hidden" name="rewards[{{$i}}][master_reward_id]" class="" value="{{ old('master_reward_id') ? old('master_reward_id') : (!empty($reward['master_reward_id']) ? $reward['master_reward_id']:'') }}">
                                                        <button id="master_merchant_id" type="button" class="dropdown-toggle form-control" data-toggle="dropdown"><span data-bind="label"><?php echo !empty($reward['master_reward_id']) ? (!empty($rewardsData[$reward['master_merchant_id']][$reward['master_reward_id']])? $rewardsData[$reward['master_merchant_id']][$reward['master_reward_id']] :"Select") : "Select"?></span></button>
                                                        <ul class="dropdown-menu custom_select" role="menu">
                                                            <?php
                                                            if(!empty($rewardsData[$reward['master_merchant_id']])):
                                                                foreach ($rewardsData[$reward['master_merchant_id']] as $key => $value) {
                                                                    echo "<li><a data-val='" . $key . "'>" . $value . "</a></li>";
                                                                 }
                                                            endif;     
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="btn-group btn-input custom_select_box clearfix">
                                                        <label class="control-label">Tiers</label>
                                                        <?php
                                                            $tiers = Config::get('constants.tiers');
                                                        ?>
                                                        <input type="hidden" name="rewards[{{$i}}][tier]" class="merchant-class" value="{{ old('tier') ? old('tier') : (!empty($reward['tier']) ? $reward['tier']:'') }}">
                                                        <button id="master_merchant_id" type="button" class="dropdown-toggle form-control" data-toggle="dropdown"><span data-bind="label"><?php echo !empty($reward['tier']) ? (!empty($tiers[$reward['tier']])? $tiers[$reward['tier']] :"Select Gym Group") : "Select"?></span></button>
                                                        <ul class="dropdown-menu custom_select" role="menu">
                                                            <?php
                                                            foreach ($tiers as $key => $value) {
                                                                echo "<li><a data-val='" . $key . "'>" . $value . "</a></li>";
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group2">
                                                      <label class="control-label">Expiry</label>
                                                      <input type="text" class="form-control" placeholder="Days" name="rewards[{{$i}}][expiry]" value="{{ $reward['expiry'] }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="del-beacon">&times;</div>
                                        </div>
                                    @php $i++;    endforeach; 
                                    else: @endphp
                                            <div class="beacon-group">  
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="btn-group btn-input custom_select_box clearfix">
                                                            <label class="control-label">Merchants</label>
                                                            <input type="hidden" name="rewards[0][master_merchant_id]" class="" value="{{ old('master_merchant_id') ? old('master_merchant_id') : (!empty($ecosystemData['master_merchant_id']) ? $ecosystemData['master_merchant_id']:'') }}">
                                                            <button id="master_merchant_id" type="button" class="dropdown-toggle form-control" data-toggle="dropdown"><span data-bind="label"><?php echo !empty($ecosystemData['master_merchant_id']) ? (!empty($merchants[$ecosystemData['master_merchant_id']])? $merchants[$ecosystemData['master_merchant_id']] :"Select Gym Group") : "Select"?></span></button>
                                                            <ul class="dropdown-menu custom_select merchant-class" role="menu">
                                                                <?php
                                                                foreach ($merchants as $key => $value) {
                                                                    echo "<li><a data-val='" . $key . "'>" . $value . "</a></li>";
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="btn-group btn-input custom_select_box reward-list-class clearfix">
                                                            <label class="control-label">Rewards</label>
                                                            <input type="hidden" name="rewards[0][master_reward_id]" class="" value="{{ old('master_merchant_id') ? old('master_merchant_id') : (!empty($ecosystemData['master_merchant_id']) ? $ecosystemData['master_merchant_id']:'') }}">
                                                            <button id="master_merchant_id" type="button" class="dropdown-toggle form-control" data-toggle="dropdown"><span data-bind="label"><?php echo !empty($ecosystemData['master_merchant_id']) ? (!empty($merchants[$ecosystemData['master_merchant_id']])? $merchants[$ecosystemData['master_merchant_id']] :"Select Gym Group") : "Select"?></span></button>
                                                            <ul class="dropdown-menu custom_select" role="menu">

                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="btn-group btn-input custom_select_box clearfix">
                                                            <label class="control-label">Tiers</label>
                                                            <?php
                                                                $tiers = Config::get('constants.tiers');
                                                            ?>
                                                            <input type="hidden" name="rewards[0][tier]" class="merchant-class" value="{{ old('master_merchant_id') ? old('master_merchant_id') : (!empty($ecosystemData['master_merchant_id']) ? $ecosystemData['master_merchant_id']:'') }}">
                                                            <button id="master_merchant_id" type="button" class="dropdown-toggle form-control" data-toggle="dropdown"><span data-bind="label"><?php echo !empty($ecosystemData['master_merchant_id']) ? (!empty($merchants[$ecosystemData['master_merchant_id']])? $merchants[$ecosystemData['master_merchant_id']] :"Select Gym Group") : "Select"?></span></button>
                                                            <ul class="dropdown-menu custom_select" role="menu">
                                                                <?php
                                                                foreach ($tiers as $key => $value) {
                                                                    echo "<li><a data-val='" . $key . "'>" . $value . "</a></li>";
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group2">
                                                          <label class="control-label">Expiry</label>
                                                          <input type="text" class="form-control" placeholder="Days" name="rewards[0][expiry]" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="del-beacon">&times;</div>
                                            </div>
                                        @php endif; @endphp  
                                </div>
                                <div class="col-sm-6">
                                    <a id="add-beacon-btn" class="">Add new reward</a>
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
<script src="{{asset('js/admin/ecosystem.js')}}"></script>
@stop
