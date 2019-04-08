<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from demo.neontheme.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Dec 2018 03:16:05 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<!-- /Added by HTTrack -->

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="Laborator.co" />
    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}">
    <title>Neon</title>
    <link rel="stylesheet" href="{{asset('assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css')}}" id="style-resource-1">
    <link rel="stylesheet" href="{{asset('assets/css/font-icons/font-awesome/css/font-awesome.min.css')}}" id="style-resource-2">
    <link rel="stylesheet" href="{{asset('assets/css/font-icons/entypo/css/entypo.css')}}" id="style-resource-2">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic" id="style-resource-3">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}" id="style-resource-4">
    <link rel="stylesheet" href="{{asset('assets/css/neon-core.css')}}" id="style-resource-5">
    <link rel="stylesheet" href="{{asset('assets/css/neon-theme.css')}}" id="style-resource-6">
    <link rel="stylesheet" href="{{asset('assets/css/neon-forms.css')}}" id="style-resource-7">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" id="style-resource-8">
    <script src="{{asset('assets/js/jquery-1.11.3.min.js')}}"></script>
    <script src="{{asset('assets/js/vuejs/vue.js')}}"></script>
    <script src="{{asset('assets/js/pagination.js')}}"></script>
     <script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
     <!-- <link rel="stylesheet" href="{{asset('assets/css/skins/green.css')}}" id="style-resource-9"> -->
<!--      <script  src="{{asset('assets/js/raphael-min.js')}}" id="script-resource-10"></script> -->
<!--     <script src="{{asset('assets/js/morris.min.js')}}" id="script-resource-11"></script>
    <script type="text/javascript" src="{{asset('assets/js/neon-charts.js')}}"></script> -->
     <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
 <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script> -->
 <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
   
    <!--[if lt IE 9]><script src="https://demo.neontheme.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]> <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script> <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> <![endif]-->
    <!-- TS1545016568: Neon - Responsive Admin Template created by Laborator -->
</head>

@guest
    <body class="page-body login-page login-form-fall" data-url="">
         
             @yield('content')
       
@else
<body class="page-body page-fade" data-url="https://demo.neontheme.com">
    <!-- TS15450165685559: Xenon - Boostrap Admin Template created by Laborator / Please buy this theme and support the updates -->
    <div class="page-container">
        <!-- TS154501656812055: Xenon - Boostrap Admin Template created by Laborator / Please buy this theme and support the updates -->
        <div class="sidebar-menu">
            <div class="sidebar-menu-inner">
                <header class="logo-env">
                    <!-- logo -->
                    <div class="logo">
                        <a href="dashboard/main/index.html"> <img src="{{asset('assets/images/logo%402x.png')}}" width="120" alt="" /> </a>
                    </div>
                    <!-- logo collapse icon -->
                    <div class="sidebar-collapse">
                        <a href="#" class="sidebar-collapse-icon">
                            <!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition --><i class="entypo-menu"></i> </a>
                    </div>
                    <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
                    <div class="sidebar-mobile-menu visible-xs">
                        <a href="#" class="with-animation">
                            <!-- add class "with-animation" to support animation --><i class="entypo-menu"></i> </a>
                    </div>
                </header>
                <ul id="main-menu" class="main-menu">
                      <li style="cursor:default;">
                             <a href="#">
                                    
                                 <span class="title">Performance Monitoring System</span>
                                </a> 
                 
                       </li>
                   @yield('sidebar') 
                   
                </ul>
            </div>
        </div>
        <div class="main-content">
            <!-- TS154501656816494: Xenon - Boostrap Admin Template created by Laborator / Please buy this theme and support the updates -->
            <div class="row">
                <!-- Profile Info and Notifications -->
                <div class="col-md-6 col-sm-8 clearfix">
                    <ul class="user-info pull-left pull-none-xsm">
                        <!-- Profile Info -->
                        <li class="profile-info dropdown">
                            <!-- add class "pull-right" if you want to place this from right -->
                            <a href="#" style="text-align: center;" class="dropdown-toggle" data-toggle="dropdown"> <img src="{{asset('assets/images/thumb-1%402x.png')}}" alt="" class="img-circle" width="44" /> {{auth()->user()->name}}
                            </a>
                            <ul class="dropdown-menu">
                                <!-- Reverse Caret -->
                                <li class="caret"></li>
                                <!-- Profile sub-links -->
                                <li>
                                    <a href="/profile_edit/{{encrypt(auth()->user()->id)}}"> <i class="entypo-user"></i> Edit Profile
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}" 
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                             <i class="entypo-logout"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    
                </div>
                <!-- Raw Links -->
                <div class="col-md-6 col-sm-4 clearfix hidden-xs">
                    <ul class="list-inline links-list pull-right">
                       
                        <li> <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                     
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
Log Out <i class="entypo-logout right"></i> </a> </li>
                    </ul>
                </div>
            </div>
            <hr />
            <!-- TS1545016568829: Xenon - Boostrap Admin Template created by Laborator / Please buy this theme and support the updates -->
            
            
           

            <div class="content">
                @yield('content')
            </div>

            <br />
            
            <br />
             <br />
          
        
            <!-- TS15450165689515: Xenon - Boostrap Admin Template created by Laborator / Please buy this theme and support the updates -->
            <!-- Footer -->
            <footer class="main">
                <div class="pull-right"> <a href="https://themeforest.net/item/neon-bootstrap-admin-theme/6434477?ref=Laborator" target="_blank"><strong>Purchase this theme for $25</strong></a> </div>
                &copy; 2018 <strong>Neon</strong> Admin Theme by <a href="https://laborator.co/" target="_blank">Laborator</a> </footer>
        </div>
        <!-- TS1545016568895: Xenon - Boostrap Admin Template created by Laborator / Please buy this theme and support the updates -->
        
        <!-- Chat Histories -->
            
        <!-- Chat Histories -->
        
    </div>
    @endguest
    <!-- TS154501656818315: Xenon - Boostrap Admin Template created by Laborator / Please buy this theme and support the updates -->
    <!-- Sample Modal (Default skin) -->
    
    <!-- Sample Modal (Skin inverted) -->

    <!-- Sample Modal (Skin gray) -->
    
    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="{{asset('assets/js/datatables/datatables.css')}}" id="style-resource-1">
    <link rel="stylesheet" href="{{asset('assets/js/select2/select2-bootstrap.css')}}" id="style-resource-2">
    <link rel="stylesheet" href="{{asset('assets/js/select2/select2.css')}}" id="style-resource-3">

    <script src="{{asset('assets/js/datatables/datatables.js')}}" id="script-resource-8"></script>
    <script src="{{asset('assets/js/select2/select2.min.js')}}" id="script-resource-9"></script>

    <link rel="stylesheet" href="{{asset('assets/js/jvectormap/jquery-jvectormap-1.2.2.css')}}" id="style-resource-1">
    <link rel="stylesheet" href="{{asset('assets/js/rickshaw/rickshaw.min.css')}}" id="style-resource-2">
    <script src="{{asset('assets/js/gsap/TweenMax.min.js')}}" id="script-resource-1"></script>
    <script src="{{asset('assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js')}}" id="script-resource-2"></script>
    <script src="{{asset('assets/js/bootstrap.js')}}" id="script-resource-3"></script>
    <script src="{{asset('assets/js/joinable.js')}}" id="script-resource-4"></script>

    <script src="{{asset('assets/js/resizeable.js')}}" id="script-resource-5"></script>
    <script src="{{asset('assets/js/neon-api.js')}}" id="script-resource-6"></script>
    <script src="{{asset('assets/js/cookies.min.js')}}" id="script-resource-7"></script>
    <script src="{{asset('assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js')}}" id="script-resource-8"></script>
    <script src="{{asset('assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js')}}" id="script-resource-9"></script>
    <script src="{{asset('assets/js/jquery.sparkline.min.js')}}" id="script-resource-10"></script>
    <script src="{{asset('assets/js/rickshaw/vendor/d3.v3.js')}}" id="script-resource-11"></script>
    <script src="{{asset('assets/js/rickshaw/rickshaw.min.js')}}" id="script-resource-12"></script>

    <script src="{{asset('assets/js/toastr.js')}}" id="script-resource-15"></script>
    <script src="{{asset('assets/js/neon-chat.js')}}" id="script-resource-16"></script>

    <!-- JavaScripts initializations and stuff -->
    <script src="{{asset('assets/js/neon-custom.js')}}" id="script-resource-17"></script>
    <!-- Demo Settings -->
    <script src="{{asset('assets/js/neon-demo.js')}}" id="script-resource-18"></script>
    <script src="{{asset('assets/js/neon-skins.js')}}" id="script-resource-19"></script>

    <script src="{{asset('assets/js/jquery.validate.min.js')}}" id="script-resource-8"></script>
     <script src="{{asset('assets/js/neon-login.js')}}" id="script-resource-9"></script>

     <script src="https://unpkg.com/page/page.js"></script>

      
 <script type="text/javascript">
          $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    </script>

<script type="text/javascript">
  
</script>

<!--     <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-28991003-7']);
        _gaq.push(['_setDomainName', 'demo.neontheme.com']);
        _gaq.push(['_trackPageview']);
        (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
    </script> -->
</body>
<!-- Mirrored from demo.neontheme.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Dec 2018 03:16:30 GMT -->

</html>