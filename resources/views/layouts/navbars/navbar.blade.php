<header class="navbar navbar-horizontal navbar-expand-lg navbar-dark flex-row align-items-md-center bg-primary"
        style="padding: .5rem 0;"
>
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-default">
            <div class="navbar-collapse-header">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
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

            <ul class="navbar-nav flex-row mr-auto ml-4">
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="{{ route('managers.index') }}">
                        <i class="fas fa-users"></i>
                        <span class="nav-link-inner--text">Teams</span>
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
