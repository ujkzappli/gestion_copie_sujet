<div class="header">
    <nav class="navbar py-4">
        <div class="container-xxl">

            <!-- header rightbar icon -->
            <div class="h-right d-flex align-items-center mr-5 mr-lg-0 order-1">
                <div class="d-flex">
                    <a class="nav-link text-primary collapsed" href="{{ url('help.html') }}" title="Get Help">
                        <i class="icofont-info-square fs-5"></i>
                    </a>
                </div>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Notifications
                        @if(auth()->user()->unreadNotifications->count())
                            <span class="badge bg-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="min-width: 300px;">
                        @forelse(auth()->user()->unreadNotifications->take(5) as $notif)
                            <li>
                                <a class="dropdown-item fw-bold" href="{{ route('notifications.show', $notif->id) }}">
                                    {{ $notif->data['title'] }}
                                    <br>
                                    <small class="text-muted">
                                        {{ Str::limit($notif->data['message'], 50) }}
                                    </small>
                                </a>
                            </li>
                        @empty
                            <li class="dropdown-item text-muted">Aucune notification</li>
                        @endforelse
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-center" href="{{ route('notifications.index') }}">
                                Voir toutes les notifications
                            </a>
                        </li>
                    </ul>
                </li>
                
                <div class="dropdown user-profile ml-2 ml-sm-3 d-flex align-items-center zindex-popover">
                    <div class="u-info me-2">
                        <p class="mb-0 text-end line-height-sm">
                            <span class="font-weight-bold">{{ Auth::user()->nom_utilisateur }} {{ Auth::user()->prenom_utilisateur }}</span>
                        </p>
                        <small>{{ Auth::user()->type }}</small>
                    </div>
                    <a class="nav-link dropdown-toggle pulse p-0" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static">
                        <img class="avatar lg rounded-circle img-thumbnail"
                            src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('assets/images/lg/avatar4.svg') }}"
                            alt="profile">
                    </a>

                    <div class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-end p-0 m-0">
                        <div class="card border-0 w280">
                            <div class="card-body pb-0">
                                <div class="d-flex py-1">
                                    <img class="avatar rounded-circle"
                                        src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('assets/images/lg/avatar4.svg') }}"
                                        alt="profile">
                                    <div class="flex-fill ms-3">
                                        <p class="mb-0">
                                            <span class="font-weight-bold">{{ Auth::user()->nom_utilisateur }} {{ Auth::user()->prenom_utilisateur }}</span>
                                        </p>
                                        <small>{{ Auth::user()->email }}</small>
                                    </div>
                                </div>
                                <div><hr class="dropdown-divider border-dark"></div>
                            </div>

                            <div class="list-group m-2">
                                <!-- Profil -->
                                <a href="{{ route('profile') }}" class="list-group-item list-group-item-action border-0">
                                    <i class="icofont-ui-user fs-5 me-3"></i>Profile
                                </a>

                                <!-- Déconnexion -->
                                <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="list-group-item list-group-item-action border-0">
                                    <i class="icofont-logout fs-5 me-3"></i>Déconnexion
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                
               
                <div class="setting ms-2">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#Settingmodal"><i class="icofont-gear-alt fs-5"></i></a>
                </div>
            </div>

            <!-- menu toggler -->
            <button class="navbar-toggler p-0 border-0 menu-toggle order-3" type="button" data-bs-toggle="collapse" data-bs-target="#mainHeader">
                <span class="fa fa-bars"></span>
            </button>

            <!-- main menu Search-->
            <div class="order-0 col-lg-4 col-md-4 col-sm-12 col-12 mb-3 mb-md-0 ">
                <div class="input-group flex-nowrap input-group-lg">
                    <input type="search" class="form-control" placeholder="Search" aria-label="search" aria-describedby="addon-wrapping">
                    <button type="button" class="input-group-text" id="addon-wrapping"><i class="fa fa-search"></i></button>
                </div>
            </div>

        </div>
    </nav>
</div>