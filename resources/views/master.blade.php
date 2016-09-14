<!DOCTYPE html>
<html>
<head>
        @yield('title')
        <title>Administrator Panel</title>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>Ultra Admin : Widgets</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <link rel="{{ asset('assetAdmin/shortcut icon') }}" href="{{ asset('assetAdmin/assets/images/favicon.png') }}" type="image/x-icon" />    <!-- Favicon -->
        <link rel="apple-touch-icon-precomposed" href="{{ asset('assetAdmin/assets/images/apple-touch-icon-57-precomposed.png') }}">    <!-- For iPhone -->
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('assetAdmin/assets/images/apple-touch-icon-114-precomposed.png') }}">    <!-- For iPhone 4 Retina display -->
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('assetAdmin/assets/images/apple-touch-icon-72-precomposed.png') }}">    <!-- For iPad -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('assetAdmin/assets/images/apple-touch-icon-144-precomposed.png') }}">    <!-- For iPad Retina display -->

        <!-- CORE CSS FRAMEWORK - START -->
        <link href="{{ asset('assetAdmin/assets/plugins/pace/pace-theme-flash.css') }}" rel="stylesheet" type="text/css" media="screen"/>
        <link href="{{ asset('assetAdmin/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assetAdmin/assets/plugins/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
        <link href="{{ asset('assetAdmin/assets/fonts/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assetAdmin/assets/css/animate.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assetAdmin/assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS FRAMEWORK - END -->


        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <link href="{{ asset('assetAdmin/assets/plugins/icheck/skins/minimal/white.css') }}" rel="stylesheet" type="text/css" media="screen"/>
        <link href="{{ asset('assetAdmin/assets/plugins/jvectormap/jquery-jvectormap-2.0.1.css') }}" rel="stylesheet" type="text/css" media="screen"/>        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 

        <!-- CORE CSS TEMPLATE - START -->
        <link href="{{ asset('assetAdmin/assets/css/style.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assetAdmin/assets/css/responsive.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assetAdmin/assets/css/mystyle.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assetAdmin/assets/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->
        
         @yield('style')
</head>
<body>
        <div class='page-topbar '>
            <nav class="navbar navbar-default">
              <div class="container-fluid">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <div class="">
                    <a class="navbar-brand" href="/">GTS Customers</a>
                  </div>
                </div>

                <div class="collapse navbar-collapse" id="myNavbar">
                  <ul class="nav navbar-nav" id="navar-small">
                    @if( Auth::user()->role_id_for == 1 )
                        <li class="text-center"><a href="/users">Users</a></li>
                        <li class="text-center"><a href="/role">Role</a></li>
                        <li class="text-center"><a href="/status">Status</a></li>
                    @else                        
                        <li class="text-center"><a href="/customers">Customers</a></li>                    
                        <li  class="text-center"><a href="/devices">Devices</a></li>
                    @endif
                  </ul>
                  <div class="text-center">
                  <ul class="nav navbar-nav navbar-right">
                        @if (Auth::guest())
                            <li><a href="{{ url('/users/login') }}">Login</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/logout') }}"><i class="fa fa-user"></i> Profile</a></li>
                                    <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> Logout</a></li>
                                </ul>
                            </li>
                        @endif
                  </ul>
                  </div>
                </div>
                
              </div>
            </nav>
        </div>
        <!-- END TOPBAR -->

        <!--///////////////////////////////////start menu///////////////////////////////////-->
        <!-- START CONTAINER -->
        <div class="page-container row-fluid">
            <!-- SIDEBAR - START -->
            <div class="page-sidebar ">
                <!-- MAIN MENU Sibar - START -->
                <div class="page-sidebar-wrapper" id="main-menu-wrapper"> 
                    <ul class='wraplist'> 
                        @if( Auth::user()->role_id_for == 1 ) 
                            <li class="">
                                <a href="{{ URL::to('/customers') }}">
                                    <i class="fa fa-users"></i><span class="title">Customers</span>
                                </a>
                            </li>

                            <li class="">
                                <a href="{{ URL::to('/devices') }}">
                                    <i class="fa fa-server" aria-hidden="true"></i><span class="title">Devices</span>
                                </a>
                            </li>

                            <li class="">
                                <a href="{{ URL::to('users') }}">
                                    <i class="fa fa-user"></i><span class="title">Users</span>
                                </a>
                            </li>

                            <li class="">
                                <a href="{{ URL::to('role') }}">
                                    <i class="fa fa-user"></i><span class="title">Role</span>
                                </a>
                            </li>
                        @else
                            <li class="">
                                <a href="{{ URL::to('/customers') }}">
                                    <i class="fa fa-users"></i><span class="title">Customers</span>
                                </a>
                            </li>

                            <li class="">
                                <a href="{{ URL::to('/devices') }}">
                                    <i class="fa fa-server" aria-hidden="true"></i><span class="title">Devices</span>
                                </a>
                            </li>
                        @endif

                    </ul>

                </div>
                <!-- MAIN MENU - END -->
            </div>
            
            
            <!--  SIDEBAR - END -->
            <!-- START CONTENT -->
            <section id="main-content" class=" ">
                <section class="wrapper" style='margin-top:60px;display:inline-block;width:100%;padding:15px 0 0 15px;'>
                    <div class="clearfix"></div>
                    <div class="">
                        @yield('contain')
                    </div>
                </section>
            </section>
            <!-- END CONTENT --> 
        </div>
        
    
    <!-- END CONTAINER -->
        <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->
        <!-- CORE JS FRAMEWORK - START --> 
        <script src="{{ asset('assetAdmin/assets/js/jquery.js') }}" type="text/javascript"></script> 
        <script src="{{ asset('assetAdmin/assets/js/jquery.easing.min.js') }}" type="text/javascript"></script> 
        <script src="{{ asset('assetAdmin/assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script> 
        <script src="{{ asset('assetAdmin/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}" type="text/javascript"></script> 
        <script src="{{ asset('assetAdmin/assets/plugins/viewport/viewportchecker.js') }}" type="text/javascript"></script>  
        <!-- CORE JS FRAMEWORK - END --> 

        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <script src="{{ asset('assetAdmin/assets/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assetAdmin/assets/plugins/count-to/countto.js') }}" type="text/javascript"></script>
        <!--<script src="{{ asset('assetAdmin/assets/plugins/jvectormap/jquery-jvectormap-2.0.1.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assetAdmin/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript"></script>
         --> 

        <!-- CORE TEMPLATE JS - START --> 
        <script src="{{ asset('assetAdmin/assets/js/scripts.js') }}" type="text/javascript"></script> 
        <!-- END CORE TEMPLATE JS - END --> 

        <!-- Sidebar Graph - START --> 
        <script src="{{ asset('assetAdmin/assets/plugins/sparkline-chart/jquery.sparkline.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assetAdmin/assets/js/chart-sparkline.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assetAdmin/assets/sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assetAdmin/assets/js/bootpage.js') }}" type="text/javascript"></script>
        <!-- Sidebar Graph - END -->

        @yield('script')
</body>
</html>
