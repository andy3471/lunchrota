<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rota') }}</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('favicon.ico')}}" type="image/x-icon" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @error('email')
        <script type="text/javascript">
            window.onload = function() {
                    $('#loginModal').modal('show');
            };
        </script>
    @endif

    @error('password')
        <script type="text/javascript">
            window.onload = function() {
                    $('#loginModal').modal('show');
            };
        </script>
    @enderror

    @error('newpassword')
        <script type="text/javascript">
            window.onload = function() {
                    $('#changePasswordModal').modal('show');
            };
        </script>
    @enderror

    @error('currentpassword')
        <script type="text/javascript">
            window.onload = function() {
                    $('#changePasswordModal').modal('show');
            };
        </script>
    @enderror

</head>
<body>
    <div id="app">
        <div class="container-fluid header">
            <div class="row">
                <div class="col-lg-2">
                    <a href="{{ route('home') }}">
                        @if (file_exists(public_path('img/logo_override.png')))
                            <img src="{{ asset('img/logo_override.png')}}" style="width:10rem">
                        @else
                            <img src="{{ asset('img/logo_default.png')}}" style="width:10rem">
                        @endif
                    </a>
                </div>
                <div class="col-sm-10 title">
                    <h1 class="">{{ config('app.name', 'Rota') }}</h1>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-md navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Rota</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    @if (config('app.sd_rota') == true)
                        <li class="nav-item">
                            <a class="nav-link" href="https://sd-rota.adastra.co.uk/Rota2/default.aspx" target="_blank">SDRota</a>
                        </li>
                    @endif
                    @can('admin',Auth::user())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" aria-expanded="false">
                            Admin
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('filament.admin.pages.dashboard') }}">Admin Panel</a>
                        </div>
                    </li>
                    @endcan
                </ul>
                <ul class="nav navbar-nav">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link modal-link" data-toggle="modal" data-target="#loginModal">Login</a>
                    </li>
                    @if( config('app.register_enabled') )
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link">Register</a>
                        </li>
                    @endif
                    @else
                    <li class="nav-item">
                        <a class="nav-link modal-link" data-toggle="modal" data-target="#changePasswordModal">
                            Change Password
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                        >
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    @endauth
                </ul>
            </div>
        </nav>


        @if(session()->has('message'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        <main class="py-4">
            @yield('content')
        </main>

        <footer>
            <nav class="navbar navbar-expand-md navbar-light bg-light fixed-bottom">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="container-fluid">
                        <h4>
                            @guest
                                Logged Out
                            @else
                                {{ Auth::user()->name }}
                            @endauth
                        </h4>
                        <h5 class="text-right">{{ config('app.footer_text')}}</h5>
                    </div>
                </div>
            </nav>
        </footer>
    </div>

    @auth
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="{{ route('password.change') }}">
                @csrf
                <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (config('app.demo_mode') == true)
                        {{ __('auth.demochangepassword') }}
                    @else
                    <div class="form-group row">

                        <label for="Current Password" class="col-md-4 col-form-label text-md-right">Current Password</label>

                        <div class="col-md-6">
                            <input id="email" type="password" class="form-control @error('currentpassword') is-invalid @enderror" name="currentpassword" required autofocus>
                            @error('currentpassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="New Password" class="col-md-4 col-form-label text-md-right">New Password</label>

                        <div class="col-md-6">
                            <input id="email" type="password" class="form-control @error('newpassword') is-invalid @enderror" name="newpassword" required>
                            @error('newpassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Confirm Password" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                        <div class="col-md-6">
                            <input id="email" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="newpassword_confirmation" required>
                        </div>
                    </div>
                    @endif

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    @if (!config('app.demo_mode') == true)
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    @endif
                </div>
                </div>
            </form>
        </div>
    </div>
    @else
    <div class="modal fade show" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="loginModalLabel">Login</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if (config('app.demo_mode') == true)
                            {{ __('auth.demomodelogin') }}
                        @endif
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email"
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email"
                                    @if (config('app.demo_mode') == true)
                                        value="admin@admin.com"
                                    @else
                                        value="{{ old('email') }}"
                                    @endif
                                    required
                                    autocomplete="email"
                                    autofocus
                                >

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password"
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                >

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if (config('app.reset_password_enabled') == true)
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                        <button type="button" class="btn btn-error" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </div>
            </form>
        </div>
        </div>
    @endauth



</body>
</html>
