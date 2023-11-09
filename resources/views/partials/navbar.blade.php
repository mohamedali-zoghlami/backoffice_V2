<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{asset('assets/images/logo-sm.png')}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset('assets/images/logo-dark.png')}}" alt="" height="17">
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{asset('assets/images/logo-sm.png')}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset('assets/images/logo-light.png')}}" alt="" height="17">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown d-md-none topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-search fs-22"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>






                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            @if(auth()->user()->image)
                            <img class="rounded-circle header-profile-user" src="{{ asset('profile_images/' . auth()->user()->image) }}" alt="">
                            @endif
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{auth()->user()->name}}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
                                    @if(auth()->user()->role==="2")
                                        Admin
                                    @else
                                        Super Admin
                                    @endif
                                </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Bienvenu {{auth()->user()->name}} !</h6>
                        <a class="dropdown-item" href="/profile"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="{{ route('logout') }}"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{$image_path}}" alt="" height="25">
                    </span>
                    <span class="logo-lg">
                        <img src="{{$image_path}}" alt="" height="50">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('assets/images/logo-sm.png')}}" alt="" height="50">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('assets/images/logo-light.png')}}" alt="" height="50">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/') }}" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i data-feather="home" class="icon-dual"></i> <span data-key="t-dashboards">Dashboard</span>
                            </a>

                        </li> <!-- end Dashboard Menu -->
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarForms" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                                <i data-feather="user" class="icon-dual"></i> <span data-key="t-forms">Connexions</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarForms">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{ url('/acteurs') }}" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                                            <span >Acteurs</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{ url('/users') }}" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                                            <span >Utilisateurs</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{ url('/admins') }}" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                                            <span >Administrateurs</span>
                                        </a>
                                    </li>
                                    @if(auth()->user()->role==="1")
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{ url('/roles') }}" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                                            <span >Rôles</span>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/fiches') }}" role="button" aria-expanded="false" aria-controls="sidebarForms">
                                <i data-feather="file" class="icon-dual"></i> <span>Fiches</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#sidebarData" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarData" data-key="t-apexcharts">  <i data-feather="database" class="icon-dual"></i> <span>Données</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarData">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="/data" class="nav-link" data-key="t-line"> Données Locales </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/dataCloud" class="nav-link" data-key="t-line"> Données Cloud </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#sidebarSoumission" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarData" data-key="t-apexcharts">  <i data-feather="mail" class="icon-dual"></i> <span>Soumissions</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarSoumission">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ url('/soumissions') }}" class="nav-link" data-key="t-line"> Publique </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/soumission/intern" class="nav-link" data-key="t-line"> Interne </a>
                                    </li>
                                </ul>
                            </div>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/suivi') }}" role="button" aria-expanded="false" aria-controls="sidebarForms">
                                <i data-feather="eye" class="icon-dual"></i> <span>Suivi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarCharts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCharts">
                                <i data-feather="settings" class="icon-dual"></i> <span data-key="t-charts">Paramètres</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarCharts">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="/groupes" class="nav-link" data-key="t-chartjs"> Groupes </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('/domaines') }}"role="button" aria-expanded="false" aria-controls="sidebarAuth">
                                            <span >Domaines</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('/formules') }}"role="button" aria-expanded="false" aria-controls="sidebarAuth">
                                            <span >Formules</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="/periodicite" class="nav-link" data-key="t-chartjs"> Périodicités </a>
                                    </li>

                                    <li class="nav-item">

                                         <a href="/dashboards" class="nav-link" data-key="t-line"> Dashboard </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="/system" class="nav-link" data-key="t-chartjs"> Système </a>
                                    </li>


                                    <li class="nav-item">
                                        <a href="{{ url('/profile') }}" class="nav-link" data-key="t-echarts"> Profile </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>

