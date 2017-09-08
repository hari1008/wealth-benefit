@extends('layouts.app')

@section('content')

        <div id="page-wrapper">
            <div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
                <div class="page-header pull-left">
                    <div class="page-title">Reported Issue Listing</div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="page-content" id="activation_code">
                 @if (session('success-message'))
                <div class="alert alert-success">
                    <?php
                    $error = session('success-message');
                    echo $error;
                    //App\Utility\CommonUtility::forgetSession('success-message');
                    
                   ?>
                </div>
            @endIf
                <div class="alert alert-danger text-left hiddenEle"> </div>
                <div class="alert alert-success text-left hiddenEle"> </div>
              
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
    <!--
                            <div class="panel-heading">
                                Users
                            </div>
    -->
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="dataTable_wrapper">
                                   
                                      <table class="table table-striped table-bordered table-hover select" id="reported_issue">
                                                <thead>
                                                    <tr>
                                                     
                                                        
                                                        <th>Reported By</th>
                                                        <th>Issue Reported</th>
                                                        <th>Description</th>
                                                        <th>Reported Date</th>
                                                        
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>
                                             
                                                </tbody>
                                            </table>
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
    
        <!-- /#page-wrapper -->
   
      @endsection
           
  @section('scripts')
   <script src="{{asset('js/admin/reported_issue.js')}}"></script>
  @stop
