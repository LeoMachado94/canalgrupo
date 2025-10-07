<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('template/assets/img/brand/logo.svg') }}" class="navbar-brand-img" alt="...">
            </a>
            <div class="ml-auto">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ in_array(Route::currentRouteName(), ['home']) ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-tachometer-alt text-primary"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        @php($names = ['clippings.index', 'clippings.create', 'clippings.edit'])
                        <a class="nav-link {{ in_array(Route::currentRouteName(), $names) ? 'active' : '' }}" href="{{ route('clippings.index') }}">
                            <i class="fas fa-clipboard-list text-orange"></i>
                            <span class="nav-link-text">Clippings</span>
                        </a>
                    </li>
                    @if(!Auth::guard('client')->user())
                    <li class="nav-item">
                        @php($names = ['clients.index', 'clients.create', 'clients.edit'])
                        <a class="nav-link {{ in_array(Route::currentRouteName(), $names) ? 'active' : '' }}" href="{{ route('clients.index') }}">
                            <i class="fas fa-users text-info"></i>
                            <span class="nav-link-text">Clientes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        @php($names = ['subjects.index', 'subjects.create', 'subjects.edit'])
                        <a class="nav-link {{ in_array(Route::currentRouteName(), $names) ? 'active' : '' }}" href="{{ route('subjects.index') }}">
                            <i class="fas fa-comments text-pink"></i>
                            <span class="nav-link-text">Assuntos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        @php($names = ['vehicles.index', 'vehicles.create', 'vehicles.edit'])
                        <a class="nav-link {{ in_array(Route::currentRouteName(), $names) ? 'active' : '' }}" href="{{ route('vehicles.index') }}">
                        <i class="fas fa-bullhorn text-default"></i>
                            <span class="nav-link-text">Veículos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        @php($names = ['editorials.index', 'editorials.create', 'editorials.edit'])
                        <a class="nav-link {{ in_array(Route::currentRouteName(), $names) ? 'active' : '' }}" href="{{ route('editorials.index') }}">
                            <i class="far fa-newspaper text-red"></i>
                            <span class="nav-link-text">Editorias/Programas</span>
                        </a>
                    </li>

{{--                    <li class="nav-item">--}}
{{--                        @php($names = ['summaries.index', 'summaries.create', 'summaries.edit'])--}}
{{--                        <a class="nav-link {{ in_array(Route::currentRouteName(), $names) ? 'active' : '' }}" href="{{ route('summaries.index') }}">--}}
{{--                            <i class="far fa-file-alt text-green"></i>--}}
{{--                            <span class="nav-link-text">Resumos</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <li class="nav-item">
                        @php($names = ['reports.index', 'reports.show'])
                        <a class="nav-link {{ in_array(Route::currentRouteName(), $names) ? 'active' : '' }}" href="{{ route('reports.index') }}">
                            <i class="ni ni-chart-pie-35 text-info"></i>
                            <span class="nav-link-text">Relatórios</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        @php($names = ['favorites.index', 'favorites.show'])
                        <a class="nav-link {{ in_array(Route::currentRouteName(), $names) ? 'active' : '' }}" href="{{ route('favorites.index') }}">
                            <i class="far fa-star text-yellow"></i>
                            <span class="nav-link-text">Favoritos</span>
                        </a>
                    </li>
                    @endif
                </ul>
                @if(!Auth::guard('client')->user())
                <!-- Divider -->
                <hr class="my-3">
                <!-- Navigation -->
                <ul class="navbar-nav mb-md-3">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog"></i>
                            <span class="nav-link-text">Configurações</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        @php($names = ['users.index', 'users.create', 'users.edit'])
                        <a class="nav-link {{ in_array(Route::currentRouteName(), $names) ? 'active' : '' }}" href="{{ route('users.index') }}">
                            <i class="fas fa-user"></i>
                            <span class="nav-link-text">Usuários</span>
                        </a>
                    </li>
                </ul>
                @endif
            </div>
        </div>
    </div>
</nav>
