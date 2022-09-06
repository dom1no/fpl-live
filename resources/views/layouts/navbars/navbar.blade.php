<header class="navbar navbar-expand-lg bg-primary navbar-dark position-sticky top-0 py-3"
    style="z-index: 99;"
>
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img class="mt--2" src="{{ asset('img') }}/logo.png" width="30">
            <span class="display-4">{{ config('app.name') }}</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-default">
            <div class="navbar-collapse-header">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img class="mt--2" src="{{ asset('img') }}/logo.png">
                            <span class="display-4">{{ config('app.name') }}</span>
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false" aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>

            <ul class="navbar-nav navbar-nav-hover">
                @auth
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="{{ route('managers.index') }}">
                            <i class="fas fa-users"></i>
                            <span class="nav-link-inner--text">Лига</span>
                        </a>
                    </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="{{ route('fixtures.index') }}">
                        <i class="fas fa-futbol"></i>
                        <span class="nav-link-inner--text">Матчи</span>
                    </a>
                </li>
                @if (auth()->user() && auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="{{ route('managers.detail-list') }}">
                            <i class="fas fa-list"></i>
                            <span class="nav-link-inner--text">Лига (детальная)</span>
                        </a>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="{{ route('home') }}">
                            <i class="fas fa-user"></i>
                            <span class="nav-link-inner--text">{{ auth()->user()->name }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-in-alt"></i>
                            <span class="nav-link-inner--text">Выйти</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i>
                            <span class="nav-link-inner--text">Войти</span>
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</header>
