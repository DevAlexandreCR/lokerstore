<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
        window.App = {}
    </script>
    <script type="module" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.esm.js"></script>
</head>
<body>
<div id="app" class="background-home">
    <nav class="navbar sticky-top navbar-expand-md navbar-dark shadow" id="nav-app">
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
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ trans('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @auth('admin')
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::guard('admin')->user()->name }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                   onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ trans('fields.logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @else
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ trans('fields.login') }}</a>
                            </li>
                            <li class="nav-item d-sm-none">
                                <a class="nav-link" href="{{route('home', 'show?tags=Mujer')}}">{{trans('fields.woman')}}</a>
                            </li>
                            <li class="nav-item d-sm-none">
                                <a class="nav-link" href="{{route('home', 'show?tags=Hombre')}}">{{trans('fields.man')}}</a>
                            </li>
                            <li class="nav-item d-sm-none">
                                <a class="nav-link" href="{{route('home', 'show?')}}">{{trans('actions.view_all')}}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ trans('actions.register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item d-sm-none">
                                <a class="nav-link" href="{{route('home', 'show?tags=Mujer')}}">{{trans('fields.woman')}}</a>
                            </li>
                            <li class="nav-item d-sm-none">
                                <a class="nav-link" href="{{route('home', 'show?tags=Hombre')}}">{{trans('fields.man')}}</a>
                            </li>
                            <li class="nav-item d-sm-none">
                                <a class="nav-link" href="{{route('home', 'show?')}}">{{trans('actions.view_all')}}</a>
                            </li>
                            <li class="nav-item dropdown">
                                <button id="navbarDropdown" class="nav-link btn  btn-link" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <ion-icon size="small" name="person-circle-outline"></ion-icon>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a href="{{route('user.profile', auth()->id())}}" class="dropdown-item btn">
                                        {{ trans('users.account') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ trans('fields.logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <form action="{{route('cart.show', auth()->id())}}" method="GET">
                                <button type="submit" class="nav-link btn btn-link">
                                    <ion-icon size="small" name="cart-outline"></ion-icon>
                                    @if(auth()->user()->hasVerifiedEmail() && auth()->user()->cart->countProducts() > 0)
                                        <span class="badge bg-red">{{auth()->user()->cart->countProducts()}}</span>
                                    @endif
                                </button>
                            </form>
                        @endguest
                    @endauth

                </ul>
            </div>
        </div>
    </nav>

    <main class="py-0 min-vh-100">
        @include('toast')
        @yield('content')
    </main>
</div>
</body>
<footer style="z-index: 100">
    @yield('footer', View::make('footer'))
</footer>
</html>
