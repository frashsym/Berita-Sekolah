<!-- header -->
<div class="header">
    <div class="container-fluid">
        <div class="row d_flex">
            <div class=" col-md-2 col-sm-5 col logo_section">
                <div class="full">
                    <div class="center-desk">
                        <div class="logo">
                            <a href="{{ url('/') }}"><img src="{{ asset('images/Neper.png') }}" alt="#"
                                    style="width: 60px; height: 60px;" /></a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-12">
                <nav class="navigation navbar navbar-expand-md navbar-dark ">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04"
                        aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarsExample04">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="nav-item {{ request()->is('about') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/about') }}">About</a>
                            </li>
                            <li class="nav-item {{ request()->is('kategori') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/kategori') }}">Kategori</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- end header inner -->
<!-- end header -->
