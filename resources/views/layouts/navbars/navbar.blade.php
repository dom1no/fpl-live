<header class="navbar navbar-expand-lg bg-primary navbar-dark position-sticky top-0 py-3"
    style="z-index: 99;"
>
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('img') }}/logo.png" width="26">
            {{ config('app.name') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-default">
            <div class="navbar-collapse-header">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('img') }}/logo.png" width="26">
                            {{ config('app.name') }}
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

            <ul class="navbar-nav navbar-nav-hover mr-auto ml-4">
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="{{ route('managers.index') }}">
                        <i class="fas fa-users"></i>
                        <span class="nav-link-inner--text">Managers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="{{ route('fixtures.index') }}">
                        <i class="fas fa-futbol"></i>
                        <span class="nav-link-inner--text">Fixtures</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>
