@extends('layouts.app')

@section('content')

        <!-- Navigation -->
     

        <div id="page-wrapper">
            <div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
                <div class="page-header pull-left">
                    <div class="page-title">Dashboard</div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="page-content">
                @if (session('success-message'))
                <div class="alert alert-success">
                    <?php
                    $error = session('success-message');
                    echo $error;
                    App\Utility\CommonUtility::forgetSession('success-message');
                    
                   ?>
                </div>
            @endIf
             <div class="alert alert-danger errors hiddenEle"></div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <!-- /.panel-heading -->
                            <div class="panel-body list_in_table">
                                <div class="dataTable_wrapper">
<!--                                    <form id="venues_form">-->
                                        <div class="report_main_content">
<!--                                            <div class="form-group">
                                                <a class="btn btn-default btn-addVenue" href="{{URL::to('/add-venue')}}" type="button"><i class="fa fa-plus-square"></i>Add Venue</a>
                                                <button class="btn btn-default btn-editVenue" type="button"><i class="fa fa-pencil-square"></i>Edit Venue</button>
                                                <button class="btn btn-default btn-deleteVenues" type="button"><i class="fa fa-trash"></i>Delete Venues</button>
                                            </div>-->
                                            <div class="clearfix"></div>
                                           
                                        </div>
<!--                                    </form>-->
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

@endsection
