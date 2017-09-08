<?php
use Illuminate\Support\Facades\Config;
$user_type_by_val = Config ::get('constants.user_type_by_val');
$user_type = Config ::get('constants.user_type');
$is_interested_for_expert = Config ::get('constants.is_interested_for_expert');
$expert_type = Config ::get('constants.expert_type');
$activation_type_by_val = Config ::get('constants.activation_type_by_val');
$expert_type_by_val = Config ::get('constants.expert_type_by_val');
?>

@extends('layouts.app') @section('content')
<div id="page-wrapper">
    <div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
        <div class="page-header pull-left">
            <?php
          
                if(!empty($userDetail->last_name)){
                    $userName = $userDetail->first_name.' '.$userDetail->last_name;;
                }else if(!empty($userDetail->first_name)){
                    $userName = $userDetail->first_name;
                }else{
                    $userName='';
                }
            ?>
            <div class="page-title">
                <?php echo  $userName?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="page-content" id="user_list">
        <?php
            $count = !empty($userDetail)?count($userDetail):0;
            if($count == 0){
                echo '<div class="alert alert-danger text-left">No Detail found</div>';
            } else {
        ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                
                                <div class="col-sm-8 col-md-8">
                                    <div class="form_inner venue_det panel panel-violet">
                                        <div class="panel-heading">Basic Details</div>
                                        <div class="user_content">
                                            <div class="row">
                                                <div class="col-sm-6 label_text text-right">Full Name:</div>
                                                <div class="col-sm-6 value_text">{{!empty($userDetail->first_name) && !empty($userDetail->last_name) ? $userDetail->first_name.' '.$userDetail->last_name:$userDetail->first_name}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 label_text text-right">Email:</div>
                                                <div class="col-sm-6 value_text"><a href="mailto:{{$userDetail->email}}">{{$userDetail->email}}</a></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 label_text text-right">Bio:</div>
                                                <div class="col-sm-6 value_text">{{$userDetail->bio}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 label_text text-right">Nationality:</div>
                                                <div class="col-sm-6 value_text">{{$userDetail->nationality}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 label_text text-right">Contact:</div>
                                                <div class="col-sm-6 value_text">{{$userDetail->mobile}}</div>
                                            </div>
                                            @if ($is_interested_for_expert['expert_confirm'] == $userDetail->is_interested_for_expert || $is_interested_for_expert['expert_interested'] == $userDetail->is_interested_for_expert)
                                                    <div class="row">
                                                        <div class="col-sm-6 label_text text-right">Type of Expert:</div>
                                                        <div class="col-sm-6 value_text">{{ $expert_type[$userDetail->expert_type] }}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6 label_text text-right">Expert Contact:</div>
                                                        <div class="col-sm-6 value_text">{{$userDetail->expert_contact_number}}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6 label_text text-right">Expert Working Location:</div>
                                                        <div class="col-sm-6 value_text">{{$userDetail->working_location}}</div>
                                                    </div>
                                                @if(!empty($userDetail->SessionPrices)) 
                                                    <div class="row">
                                                        <div class="col-sm-6 label_text text-right">One Session Price:</div>
                                                        <div class="col-sm-6 value_text">{{ $userDetail->SessionPrices->one_session }}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6 label_text text-right">Ten Session Price:</div>
                                                        <div class="col-sm-6 value_text">{{ $userDetail->SessionPrices->ten_session }}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6 label_text text-right">Twenty Session Price:</div>
                                                        <div class="col-sm-6 value_text">{{ $userDetail->SessionPrices->twenty_session }}</div>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="form_inner venue_det panel panel-violet">
                                        <div class="panel-heading">Profile Image</div>
                                        <div class="col-sm-12 text-center">
                                            <div>
                                                <div class="profileLogo">
                                                     <img class="user_img" src="{{!empty($userDetail->image) ?$userDetail->image :asset('images/profile.png')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if ($is_interested_for_expert['expert_confirm'] == $userDetail->is_interested_for_expert || $is_interested_for_expert['expert_interested'] == $userDetail->is_interested_for_expert )
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form_inner venue_det panel panel-violet slot_panel">
                                        <div class="panel-heading">Expert Qualifications</div>
                                        <div class="user_content">
                                                    <div class="row">
                                           <?php
                                           if(!empty($userDetail->qualifications)){
                                               foreach($userDetail->qualifications as $qualification){
                                                   ?>
                                                        <a href="{{url('download-qualification-image/'.$qualification['qualification_id'])}}"> <div class="col-sm-3"><img class="img-responsive" src="<?php echo $qualification['qualification_image']; ?>" /></div></a>
                                            <?php
                                            }
                                           }
                                           ?>
                                              </div>           
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                             @if ($user_type['Expert'] == $userDetail->user_type && !empty($userDetail['expertcalendar']))
                             
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form_inner venue_det panel panel-violet slot_panel">
                                        <div class="panel-heading">Expert Avaliable Slots</div>
                                        <div class="user_content">
                                           <?php
                                           if(!empty($expertCalendar)){
                                               $i=0;
                                               foreach($expertCalendar as $calendars=>$calendar){
                                                  
                                                   ?>
                                              <div class="row time_slot_box">
                                                <div class="col-sm-6 label_text"><?php echo $calendar[$i]['date']?></div>
                                                <div class="col-sm-6 value_text">
                                                    <?php
                                                        foreach($calendar as $slots){
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-sm-12"><?php echo $slots['start_time']?> - <?php echo $slots['end_time']?></div>
                                                       
                                                    </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                               
                                               
                                               
                                            <?php
                                            $i++;
                                            }
                                           }
                                           ?>
                                         
               
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        <?php } ?>
    </div>
</div>
<!-- /#page-wrapper -->
@endsection  @section('scripts')
<script src="{{asset('js/admin/userlisting.js')}}"></script>
@stop
