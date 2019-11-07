<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('favicon.ico')}}" type="image/x-icon" />
</head>
<body>
    <div id="app">
        <div class="container-fluid header">
            <div class="row">
                <div class="col-lg-2">
                <a href="./rota.php"><img src="{{ asset('img/logo.png')}}" style="width:10rem"></a>
                </div>
                <div class="col-sm-10">
                    <h1 class="">{{ config('app.name', 'Rota') }}</h1>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-md navbar-light bg-light">
            <a class="navbar-brand" href="{{ route('home') }}">Rota</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://sd-rota.adastra.co.uk/Rota2/default.aspx" target="_blank">SDRota</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" aria-expanded="false">
                            Admin
                        </a>
                        <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('usersadmin') }}">Users</a>
                            <a class="dropdown-item" href="{{ route('rolesadmin') }}">Roles</a>
                        <a class="dropdown-item" href="{{ route('upload') }}">Bulk Upload</a>
                        </div>
                    </li>
                </ul>
                <ul class="nav navbar-nav">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <span class="navbar-text" disabled="">12345</span>
                    </li>
                    <li class="nav-item">
                        <span class="navbar-text" disabled="">PASSWORD</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">
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
                    </div>
                    <div class="container-fluid">
                        <h5 class="text-right">Information for Care. Everywhere.</h5>
                    </div>
                </div>
            </nav>
        </footer>
    </div>
</body>
</html>
