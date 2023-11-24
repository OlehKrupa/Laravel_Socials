<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                @auth()
                    <ul class="navbar-nav me-auto">
                        <a class="btn btn-primary" href="/news">{{__("View news")}}</a>

                        <a class="btn btn-success" href="/news/create">{{__("Offer news")}}</a>
                    </ul>
                @endauth

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if(Route::has('news.index'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('news.index') }}">{{ __('Guest') }}</a>
                            </li>
                        @endif

                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <span style="margin-left: 10px;">{{ Auth::user()->name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                                <a class="dropdown-item" href="{{route('toggle-subscription')}}"
                                   onclick="event.preventDefault(); document.getElementById('toggle-subscribe').submit();">
                                    @if(Auth::user()->is_subscribed)
                                        Unsubscribe
                                    @else
                                        Subscribe
                                    @endif
                                </a>

                                <form id="toggle-subscribe" action="{{route('toggle-subscription')}}" method="POST"
                                      class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Всплывающее окно -->
    <div id="subscriptionConfirmation" class="popup">
        @if(session('subscription_confirmation') || isset($subscription_confirmation))
            <div class="popup-content">
                <span class="close" onclick="closePopup()">&times;</span>
                <p>{{ session('subscription_confirmation') ?? 'Confirmation sent by email.' }}</p>
            </div>
        @endif
    </div>

    <script>
        function closePopup() {
            document.getElementById('subscriptionConfirmation').style.display = 'none';
        }

        window.onload = function () {
            if ('{{ session('subscription_confirmation') ?? '' }}' !== '') {
                document.getElementById('subscriptionConfirmation').style.display = 'block';
            }
        };
    </script>

    <style>
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            width: 300px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .popup-content {
            text-align: center;
        }

        .close {
            position: absolute;
            top: 0;
            right: 0;
            padding: 10px;
            cursor: pointer;
        }
    </style>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
@include('layouts.footer')
</html>
