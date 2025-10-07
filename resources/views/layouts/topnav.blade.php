<nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Search form -->
            <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
                <div class="form-group mb-0">
                    <div class="input-group input-group-alternative input-group-merge">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input class="form-control" placeholder="Pesquisar" type="text">
                    </div>
                </div>
                <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </form>
            <!-- Navbar links -->
            <ul class="navbar-nav align-items-center ml-md-auto">
                <li class="nav-item d-xl-none">
                    <!-- Sidenav toggler -->
                    <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </li>
                <li class="nav-item d-sm-none">
                    <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                        <i class="ni ni-zoom-split-in"></i>
                    </a>
                </li>
{{--                <li class="nav-item dropdown">--}}
{{--                    <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                        <i class="ni ni-bell-55"></i>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right py-0 overflow-hidden">--}}
{{--                        <!-- Dropdown header -->--}}
{{--                        <div class="px-3 py-3">--}}
{{--                            <h6 class="text-sm text-muted m-0">Você tem <strong class="text-secon">12</strong> notificações.</h6>--}}
{{--                        </div>--}}
{{--                        <!-- List group -->--}}
{{--                        <div class="list-group list-group-flush">--}}
{{--                            <a href="#!" class="list-group-item list-group-item-action">--}}
{{--                                <div class="row align-items-center">--}}
{{--                                    <div class="col-auto">--}}
{{--                                        <!-- Avatar -->--}}
{{--                                        <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">--}}
{{--                                            <i class="fas fa-tv"></i></div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col ml--2">--}}
{{--                                        <div class="d-flex justify-content-between align-items-center">--}}
{{--                                            <div>--}}
{{--                                                <h4 class="mb-0 text-sm">Clipping TV <div class="negativa">Negativo</div></h4>--}}
{{--                                            </div>--}}
{{--                                            <div class="text-right text-muted">--}}
{{--                                                <small>2 de Jan</small>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <p class="text-sm mb-0">Negativa do programa às 11:30</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                            <a href="#!" class="list-group-item list-group-item-action">--}}
{{--                                <div class="row align-items-center">--}}
{{--                                    <div class="col-auto">--}}
{{--                                        <!-- Avatar -->--}}
{{--                                        <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">--}}
{{--                                            <i class="fas fa-broadcast-tower"></i></div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col ml--2">--}}
{{--                                        <div class="d-flex justify-content-between align-items-center">--}}
{{--                                            <div>--}}
{{--                                                <h4 class="mb-0 text-sm">Clipping Rádio <div class="positiva">Positiva</div></h4>--}}
{{--                                            </div>--}}
{{--                                            <div class="text-right text-muted">--}}
{{--                                                <small>2 de Jan</small>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <p class="text-sm mb-0">Positiva do programa às 11:30</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                            <a href="#!" class="list-group-item list-group-item-action">--}}
{{--                                <div class="row align-items-center">--}}
{{--                                    <div class="col-auto">--}}
{{--                                        <!-- Avatar -->--}}
{{--                                        <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">--}}
{{--                                            <i class="fas fa-print"></i></div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col ml--2">--}}
{{--                                        <div class="d-flex justify-content-between align-items-center">--}}
{{--                                            <div>--}}
{{--                                                <h4 class="mb-0 text-sm">Clipping Impresso <div class="negativa">Negativo</div></h4>--}}
{{--                                            </div>--}}
{{--                                            <div class="text-right text-muted">--}}
{{--                                                <small>2 de Jan</small>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <p class="text-sm mb-0">Negativa do programa às 11:30</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </a>--}}

{{--                        </div>--}}
{{--                        <!-- View all -->--}}
{{--                        <a href="#!" class="dropdown-item text-center text-secon font-weight-bold py-3">Ver todas</a>--}}
{{--                    </div>--}}
{{--                </li>--}}

            </ul>
            <ul class="navbar-nav align-items-center ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                      @if(Auth::guard('client')->user())
                          <img alt="Image placeholder" src="{{ asset(Auth::guard('client')->user()->logo) ?? asset('assets/images/no_user_image.svg') }}" width="36" height="36">
                      @else
                          <img alt="Image placeholder" src="{{ Auth::user()->getAvatar() }}" width="36" height="36">
                      @endif
                  </span>
                            @if(Auth::user())
                            <div class="media-body ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm">{{ Auth::user()->name }}</span>
                            </div>
                            @endif
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Bem-vindo!</h6>
                        </div>
                        <a href="{{ route('users.edit', \Auth::user()->id) }}?perfil=true" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>Meu perfil</span>
                        </a>
                        <a href="#!" class="dropdown-item">
                            <i class="ni ni-settings-gear-65"></i>
                            <span>Configurações</span>
                        </a>

                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ni ni-user-run"></i>
                            <span>Sair</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
