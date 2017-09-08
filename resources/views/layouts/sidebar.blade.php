<nav class="navbar navbar-default navbar-static-top m-b0" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{URL::to('/')}}"><img src="{{asset('images/logo.png')}}" alt="Benefit Wellness logo"></a>
    </div>
    <!-- /.navbar-header -->
    <ul class="nav navbar-top-links navbar-right">
        <?php
        $profileImage = !empty(Auth::User()->image) ?Auth::User()->image : asset('images/profile.png');
        ?>
        <li class="user_details"><img class="user_icon" src="{{$profileImage}}"><span class="name"><?php echo
       
        !empty(Auth::User()->last_name) ? Auth::User()->first_name.' '.Auth::User()->last_name : Auth::User()->first_name
        ?></span></li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="{{URL::to('change-password')}}"><i class="fa fa-key fa-fw"></i> Change Password</a></li>
                <li id="logout_btn"><a href="{{ url('/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
            @php    
            if(Auth::user()->user_type == 4){    
            @endphp
                <li>
                    <a href="{{URL::to('merchant-listing')}}"><i class="fa fa-shopping-cart fa-fw"></i> Manage Merchants</a>
                </li>
                <li>
                    <a href="{{URL::to('reward-listing')}}"><i class="fa fa-gift fa-fw"></i> Manage Rewards</a>
                </li>
                <li>
                    <a href="{{URL::to('ecosystem-listing')}}"><i class="fa fa-th-list fa-fw"></i> Manage Eco Systems</a>
                </li>
                <li>
                    <a href="{{URL::to('user-listing')}}"><i class="fa fa-medkit fa-fw"></i> Manage Wellness Seekers</a>
                </li>
                <li>
                    <a href="{{URL::to('health-category-listing')}}"><i class="fa fa-medkit fa-fw"></i> Manage Health Categories</a>
                </li>
                <li>
                    <a href="{{URL::to('provider-listing')}}"><i class="fa fa-cutlery fa-fw"></i> Manage Food Provider</a>
                </li>
                <li>
                    <a href="{{URL::to('insurance-listing')}}"><i class="fa fa-umbrella fa-fw"></i> Manage Health Insurance</a>
                </li>
                <li>
                    <a href="{{URL::to('work-listing')}}"><i class="fa fa-bars fa-fw"></i> Manage Works</a>
                </li>
                <li>
                    <a href="{{URL::to('gym-listing')}}"><i class="fa fa-bicycle fa-fw"></i> Manage Gyms</a>
                </li>
                <li>
                    <a href="{{URL::to('reported-issue')}}"><i class="fa fa-bug fa-fw"></i> Issue Reported</a>
                </li>
                <li>
                    <a href="{{URL::to('rating-listing')}}"><i class="fa fa-star fa-fw"></i> Rating List</a>
                </li>
                <li>
                    <a href="{{URL::to('get-help-listing')}}"><i class="fa fa-question fa-fw"></i> Get Help</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-users fa-fw"></i> Users Interested In<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{URL::to('user-provider')}}"><i class="fa fa-cutlery fa-fw"></i><span class="menu-title"> Health Food Providers</span></a>
                        </li>
                        <li>
                            <a href="{{URL::to('user-insurance')}}"><i class="fa fa-umbrella fa-fw"></i><span class="menu-title"> Health Insurance</span></a>
                        </li>
                       
                    </ul>
                </li>
                <li>
                            <a href="{{URL::to('add-terms-condition')}}"><i class="fa fa-umbrella fa-fw"></i><span class="menu-title"> Settings</span></a>
                </li>
            @php 
            }
            else{
            $ecoSystem = Auth::user()->subAdminEcosystem()->first();
            @endphp
                <li>
                            <a href="{{URL::to('code-listing/'.$ecoSystem['ecosystem_id'])}}"><i class="fa fa-umbrella fa-fw"></i><span class="menu-title"> Activation Codes</span></a>
                </li>
            @php 
            }
            @endphp
            </ul>
        </div>
        <!--/.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
