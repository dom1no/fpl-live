<header class="navbar navbar-expand-lg bg-primary navbar-dark position-sticky top-0 py-3"
    style="z-index: 99;"
>
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img class="mt--2" src="{{ asset('img') }}/logo.png" width="30" alt="{{ config('app.name') }}">
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
                            <img class="mt--2" src="{{ asset('img') }}/logo.png" alt="{{ config('app.name') }}">
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
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-icon dropdown-toggle" href="#" data-toggle="dropdown">
                            <i class="fas fa-list"></i>
                            Аналитика
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('managers.detail-list') }}">
                                    <span class="nav-link-inner--text">Составы лиги</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-icon dropdown-toggle" href="#" data-toggle="dropdown">
                            <i class="fa fa-user-alt"></i>
                            <span class="nav-link-inner--text">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('home') }}">
                                    Профиль
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('home') }}#tab-tabs-stats">
                                    Статистика
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('home') }}#tab-tabs-my-fixtures">
                                    Матчи
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('home') }}#tab-tabs-transfers">
                                    Трансферы
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider"></hr>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
{{--                                    <i class="fas fa-sign-in-alt"></i>--}}
                                    <span class="nav-link-inner--text">Выйти</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <div class="dropdown-divider"></div>
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
