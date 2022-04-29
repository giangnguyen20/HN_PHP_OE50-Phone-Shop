<!DOCTYPE html>

<head>
    <title>Quản lý danh mục</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- bootstrap-css -->
    <link rel="stylesheet" href="{{ asset('bower_components/css/bootstrap.min.css') }}">
    <!-- //bootstrap-css -->
    <!-- Custom CSS -->
    <link href="{{ asset('bower_components/css/style.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ asset('bower_components/css/style-responsive.css') }}" rel="stylesheet" />
    <!-- font CSS -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <!-- font-awesome icons -->
    <link rel="stylesheet" href="{{ asset('bower_components/css/font.css') }}" type="text/css" />
    <link href="{{ asset('bower_components/css/font-awesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bower_components/css/morris.css') }}" type="text/css" />
    <!-- calendar -->
    <link rel="stylesheet" href="{{ asset('bower_components/css/monthly.css') }}">
    <!-- //calendar -->
    <!-- //font-awesome icons -->
    <script src="{{ asset('bower_components/js/jquery2.0.3.min.js') }}"></script>
    <script src="{{ asset('bower_components/js/raphael-min.js') }}"></script>
    <script src="{{ asset('bower_components/js/morris.js') }}"></script>
</head>

<body>
    <section id="container">
        <!--header start-->
        <header class="header fixed-top clearfix">
            <!--logo start-->
            <div class="brand">
                <a href="{{ route('admin.') }}" class="logo">
                    {{ __('ADMIN') }}
                </a>
                <div class="sidebar-toggle-box">
                    <div class="fa fa-bars"></div>
                </div>
            </div>
            <!--logo end-->

            <div class="nav notify-row" id="top_menu">
                <ul class="nav top-menu">
                    <li>
                        <a href="{{ route('lang', ['lang' => 'vi']) }}" style="color: white;">{{ __('VI') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('lang', ['lang' => 'en']) }}"  style="color: white;">{{ __('EN') }}</a>
                    </li>
                </ul>
            </div>
            <div class="top-nav clearfix">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img alt="" src="">
                            <span class="username">{{ Auth::user()->fullname }}</span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <i class="fa fa-key"></i>
                                    <input type="submit" value="{{ __('Logout') }}">
                                </form>
                            </li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->

                </ul>
                <!--search & user info end-->
            </div>
        </header>
        <!--header end-->
        <!--sidebar start-->
        <aside>
            <div id="sidebar" class="nav-collapse">
                <!-- sidebar menu start-->
                <div class="leftside-navigation">
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a class="active" href="{{ route('admin.') }}">
                                <span>{{ __('Dashboard') }}</span>
                            </a>
                        </li>

                        <li>
                            <a class="active" href="{{ route('admin.categories.index') }}">
                                <span>{{ __('Categories') }}</span>
                            </a>
                        </li>

                        <li>
                            <a class="active" href="{{ route('admin.products.index') }}">
                                <span>{{ __('Products') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <div class="row">
                    <div class="panel-body">
                        <div class="col-md-12 w3ls-graph">
                            <div class="panel-body">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
        <!--main content end-->
    </section>
    <script src="{{ asset('bower_components/js/bootstrap.js') }}"></script>
    <script src="{{ asset('bower_components/js/jquery.dcjqaccordion.2.7.js') }}"></script>
    <script src="{{ asset('bower_components/js/scripts.js') }}"></script>
    <script src="{{ asset('bower_components/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('bower_components/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('bower_components/js/jquery.scrollTo.js') }}"></script>
    <!-- calendar -->
    <script type="text/javascript" src="{{ asset('bower_components/js/monthly.js') }}"></script>
    <!-- //calendar -->
</body>

</html>
