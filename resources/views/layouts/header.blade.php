<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vietpro Mobile Shop</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bower_components/user/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/user/css/home.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('bower_components/user/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('bower_components/user/js/bootstrap.js') }}"></script>
</head>

<body>
    <!-- Header -->
    <div id="header">
        <div class="container">
            <div class="row">
                <div id="logo" class="col-lg-3 col-md-3 col-sm-12">
                    <a href="{{ route('home') }}"><img src="{{ asset('bower_components/user/images/logo.png') }}" alt="" /></a>
                </div>
                <div id="search-box" class="col-lg-7 col-md-7 col-sm-12 mt-1">
                    <form class="d-flex">
                        <input class="form-control" type="search" placeholder="Tìm kiếm" aria-label="Search">
                        <button class="btn" type="submit">{{ __('Search') }}</button>
                    </form>
                </div>
                <div id="cart-notify" class="col-lg-2 col-md-2 col-sm-12 mt-1">
                    <a href="#">{{ __('Cart') }} <span>8</span></a>
                    <div class="clear"></div>
                </div>
                <div id="menu-collapse" class="navbar navbar-dark">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12 mt-1">
                @guest
                @if (Route::has('login'))
                    <a class="btn btn-success" href="{{ route('login') }}">{{ __('Login') }}</a>
                @endif
                |
                @if (Route::has('register'))
                    <a class="btn btn-success" href="{{ route('register') }}">{{ __('Register') }}</a>
                @endif
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->fullname }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                            @csrf
                            <input type="submit" value="{{ __('logout') }}">
                        </form>
                    </div>
                </li>
                @endif
            </div>
        </div>
    </div>
    <!-- End Header -->
    <!-- Main -->
    <div class="container">
        @yield('content')
    </div>
    <!-- End Main -->
    <!-- Footer -->
    <div id="footer-top">
        <div class="container">
            <div class="row">
                <div id="logo-f" class="col-lg-3 col-md-6 col-sm-12">
                    <a href="#"><img src="{{ asset('bower_components/user/images/logo-footer.png') }}" alt=""></a>
                    <p>{{ __('intro_shop') }}</p>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 service">
                    <h2>{{ __('Address') }}</h2>
                    <p>{{ __('Ha Noi') }}</p>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 service">
                    <h2>{{ __('Service') }}</h2>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 service">
                    <h2>{{ __('Hotline') }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div id="footer-bot">
        <div class="container">
        </div>
    </div>
    <!-- End Footer -->
</body>

</html>
