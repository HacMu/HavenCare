<head>
    <link rel="stylesheet" href="{{ asset('Css/main.css') }}">
</head>
<nav class="header__nav">
    <div class="header__logo">
        <a href="{{ route('home') }}"><img src="{{ asset('/Images/logo-1.png') }}" alt=""></a>
    </div>
    <!-- Header NavigationBar Items Start Here -->
    <div class="header__items">
        <ul class="header__ul">
            <li class="header__li">
                @if (Route::has('login'))
                    <div class="hidden sm:block" style="z-index: 10;margin-right:64px;font-size:16px">
                        @auth
                            @include('layouts.logineduser')
                        </div>
        </div>
    @else
        <a class="header__links" href="{{ route('login') }}">Log in</a>

        @if (Route::has('register'))
            <a class="header__links" href="{{ route('register') }}" id="an">Register</a>
        @endif
    @endauth
    @endif
    </li>
    </ul>
    </div>
</nav>
