<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0 "); // Proxies.
?>
<?php
use Illuminate\Support\Facades\Auth;
?>
<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
    <body>
        <?php if(Auth::check()){ ?>
            <div>
                <div id="wrapper" class="bg">
                    <!--BEGIN SIDEBAR MENU-->
                    @include('layouts.sidebar')
                    <!--END SIDEBAR MENU-->

                    <!--BEGIN PAGE WRAPPER-->
                    @yield('content')
                    <!--END PAGE WRAPPER-->
                </div>
            </div>
            @include('layouts.footer_include')
        <?php }else{ ?>
            @yield('content')
            <!--END PAGE WRAPPER-->
            <script src="{{asset('js/app.js')}}"></script>
        <?php } ?>
    </body>
</html>
