<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column" 
    style="background: #fff4db;
    background: radial-gradient( #f3f3f3, #f5fdcb); display: flex;
    flex-direction: column;">
    <div id="app">
        <nav class="navbar sticky-top navbar-expand-md navbar-dark bg-dark  shadow-sm">
            <div class="container">
                @if (Auth::guard('admin')->check())
                <a class="navbar-brand" href="{{ url('/admin') }}">
                    {{ config('app.name') }}
                </a>
                @else
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}
                </a> 
                @endif
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @auth
                            @if (Route::is('users.index'))
                        <form class="form-inline my-2 my-lg-0" method="POST" action="{{route('users.index')}}">
                            @csrf
                                <input class="form-control mr-sm-2" type="search" name="query" placeholder="{{__('Search')}}" aria-label="Search" required>
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{__('Search')}}</button>
                            </form>
                            @endif
                        @endauth
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
 
        <main class="py-0" style="flex: 1; min-height: 100vh">
            @yield('content')
        </main>
        @yield('footer', View::make('footer'))
    </div>

<script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
</body>
</html>
