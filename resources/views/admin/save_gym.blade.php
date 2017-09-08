@extends('layouts.app') @section('content')
<div id="page-wrapper">
    <div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
        <div class="page-header pull-left">
            <div class="page-title">Gym</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="page-content" id="gym_list">
       
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
                    <div class="panel-heading">Add Gym</div>
                    <form class="form-horizontal" method="post" id="save_gym_form" name="save_gym_form" action="">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Gym Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="gym_name" placeholder="Enter the gym name " value="{{old('gym_name')? old('gym_name'): (!empty($gymData['gym_name'])? $gymData['gym_name']:'') }}">
                                <?php
                                    $gymId = isset($_GET['id']) ?$_GET['id'] :0;
                                    if($gymId > 0){
                                        $disabled='';
                                    }else{
                                        $disabled='disabled';
                                    }
                                ?>
                                <input type="hidden" class="form-control" name="master_gym_id" <?php echo $disabled;?> value="{{isset($_GET['id']) ?$_GET['id'] :0 }}" id="work_id">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Address</label>              
                            <div class="col-sm-6 location_group">
                                <a data-toggle="modal" data-target="#map_modal">
                                    <input type="text" readonly class="form-control" name="gym_address" placeholder="Choose" id="location" value="{{old('gym_address')? old('gym_address'): (!empty($gymData['gym_address'])? $gymData['gym_address']:'') }}">
                                    <input type="hidden" name="gym_lat" id="lat" value="{{old('gym_lat')? old('gym_lat'): (!empty($gymData['gym_lat'])? $gymData['gym_lat']:'') }}">
                                    <input type="hidden" name="gym_long" id="lng" value="{{old('gym_long')? old('gym_long'): (!empty($gymData['gym_long'])? $gymData['gym_long']:'') }}">
                                    <img src="{{asset('images/location.png')}}" class="map_location">
                                  </a>
                            </div>      
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Zip Code</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="zip_code" placeholder="Enter the Zip Code" value="{{old('zip_code')? old('zip_code'): (!empty($gymData['zip_code'])? $gymData['zip_code']:'') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Gym Group</label>
                            <div class="col-sm-6">
                                <div class="btn-group btn-input custom_select_box clearfix">
                                    <input type="hidden" name="master_work_id" value="{{ old('master_work_id') ? old('master_work_id') : (!empty($gymData['master_work_id']) ? $gymData['master_work_id']:'') }}">
                                    <button id="master_work_id" type="button" class="dropdown-toggle form-control" data-toggle="dropdown"><span data-bind="label"><?php echo !empty($gymData['master_work_id']) ? (!empty($gymGroups[$gymData['master_work_id']])? $gymGroups[$gymData['master_work_id']] :"Select Gym Group") : "Select Gym Group"?></span></button>
                                    <ul class="dropdown-menu custom_select" role="menu">
                                        <?php
                                        foreach ($gymGroups as $key => $value) {
                                            echo "<li><a data-val='" . $key . "'>" . $value . "</a></li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email ID</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="gym_mail_id" placeholder="Enter the Email" value="{{old('gym_mail_id')? old('gym_mail_id'): (!empty($gymData['gym_mail_id'])? $gymData['gym_mail_id']:'') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Phone Number</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="gym_phone" placeholder="Enter the Phone Number" value="{{old('gym_phone')? old('gym_phone'): (!empty($gymData['gym_phone'])? $gymData['gym_phone']:'') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Link to Gym website</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="gym_website" placeholder="Enter the Website Address" value="{{old('gym_website')? old('gym_website'): (!empty($gymData['gym_website'])? $gymData['gym_website']:'') }}">
                            </div>
                        </div>
                        <div>
                          <label class="col-sm-4 control-label">Beacon</label>
                          <div class="col-sm-6 beacon-grp">
                            @php if($gymId > 0 && !empty($gymData['beacons'][0])): 
                                    $i = 0;
                                    foreach($gymData['beacons'] as $beacons): @endphp     
                                        <div class="beacon-group">  
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group2">
                                                      <label class="control-label">ID</label>
                                                      <input type="text" class="form-control" name="beacon[{{$i}}][beacon_uuid]" value="{{ $beacons['beacon_uuid'] }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group2">
                                                      <label class="control-label">Major</label>
                                                      <input type="text" class="form-control" name="beacon[{{$i}}][beacon_major]" value="{{ $beacons['beacon_major'] }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group2">
                                                      <label class="control-label">Minor</label>
                                                      <input type="text" class="form-control" name="beacon[{{$i}}][beacon_minor]" value="{{ $beacons['beacon_minor'] }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="del-beacon">&times;</div>
                                        </div>
                            @php $i++;   endforeach; 
                                else: @endphp
                                    <div class="beacon-group">  
                                      <div class="row">
                                          <div class="col-sm-4">
                                              <div class="form-group2">
                                                <label class="control-label">ID</label>
                                                <input type="text" class="form-control" name="beacon[0][beacon_uuid]" value="">
                                              </div>
                                          </div>
                                          <div class="col-sm-4">
                                              <div class="form-group2">
                                                <label class="control-label">Major</label>
                                                <input type="text" class="form-control" name="beacon[0][beacon_major]" value="">
                                              </div>
                                          </div>
                                          <div class="col-sm-4">
                                              <div class="form-group2">
                                                <label class="control-label">Minor</label>
                                                <input type="text" class="form-control" name="beacon[0][beacon_minor]" value="">
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                            @php endif; @endphp   
                          </div>
                          <div class="col-sm-6">
                            <a id="add-beacon-btn" class="">Add new beacon</a>
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
@include('admin.map')
@endsection @section('scripts')
<script src="{{asset('js/admin/gym_listing.js')}}"></script>
@stop
