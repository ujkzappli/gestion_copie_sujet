<div class="header">
    <nav class="navbar py-3">
        <div class="container-xxl">

            {{-- Sidebar toggle + Logo mobile --}}
            <div class="d-flex align-items-center order-0">
                <button type="button" class="btn btn-link px-0 text-decoration-none me-3" id="sidebarCollapse">
                    <i class="bi bi-list fs-3 text-primary"></i>
                </button>
                <div class="d-md-none">
                    <h6 class="mb-0 fw-bold text-primary">UJKZ</h6>
                </div>
            </div>

            {{-- Barre de recherche --}}
            <div class="order-1 col-lg-5 col-md-5 d-none d-md-block">
                <div class="search-box position-relative">
                    <input type="search" 
                           class="form-control rounded-pill ps-4 pe-5" 
                           placeholder="Rechercher..." 
                           style="border: 2px solid #e9ecef; background: #f8f9fa;">
                    <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                </div>
            </div>

            {{-- Actions à droite --}}
            <div class="d-flex align-items-center gap-2 order-2">

                {{-- Aide --}}
                <a href="{{ url('help.html') }}" 
                   class="btn btn-light rounded-circle d-flex align-items-center justify-content-center"
                   style="width: 40px; height: 40px;"
                   title="Aide"
                   data-bs-toggle="tooltip">
                    <i class="bi bi-question-circle text-primary fs-5"></i>
                </a>

                {{-- Notifications --}}
                <div class="dropdown">
                    <button class="btn btn-light rounded-circle position-relative d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;"
                            data-bs-toggle="dropdown"
                            title="Notifications"
                            data-bs-toggle="tooltip">
                        <i class="bi bi-bell text-primary fs-5"></i>
                        @if(auth()->user()->unreadNotifications->count())
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>
                    
                    <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 p-0" style="min-width: 350px;">
                        {{-- Header --}}
                        <div class="px-3 py-3 border-bottom bg-light rounded-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold">
                                    <i class="bi bi-bell-fill text-primary me-2"></i>Notifications
                                </h6>
                                @if(auth()->user()->unreadNotifications->count())
                                    <span class="badge bg-primary rounded-pill">
                                        {{ auth()->user()->unreadNotifications->count() }} nouvelles
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Liste des notifications --}}
                        <div class="notification-list" style="max-height: 400px; overflow-y: auto;">
                            @forelse(auth()->user()->unreadNotifications->take(5) as $notif)
                                <a href="{{ route('notifications.show', $notif->id) }}" 
                                   class="dropdown-item border-bottom py-3 hover-bg-light">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0 bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="bi bi-info-circle text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-1 fw-semibold" style="font-size: 0.9rem;">
                                                {{ $notif->data['title'] ?? $notif->data['titre'] ?? 'Notification' }}
                                            </p>
                                            <small class="text-muted d-block" style="font-size: 0.8rem;">
                                                {{ Str::limit($notif->data['message'], 60) }}
                                            </small>
                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                <i class="bi bi-clock me-1"></i>{{ $notif->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-5">
                                    <i class="bi bi-bell-slash text-muted fs-1 mb-3"></i>
                                    <p class="text-muted mb-0">Aucune notification</p>
                                </div>
                            @endforelse
                        </div>

                        {{-- Footer --}}
                        @if(auth()->user()->unreadNotifications->count())
                            <div class="px-3 py-2 border-top bg-light text-center rounded-bottom">
                                <a href="{{ route('notifications.index') }}" 
                                   class="text-decoration-none small fw-semibold">
                                    Voir toutes les notifications
                                    <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Paramètres --}}
                <button class="btn btn-light rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px;"
                        data-bs-toggle="modal" 
                        data-bs-target="#Settingmodal"
                        title="Paramètres"
                        data-bs-toggle="tooltip">
                    <i class="bi bi-gear text-primary fs-5"></i>
                </button>

                {{-- Profil utilisateur --}}
                <div class="dropdown">
                    <button class="btn btn-light rounded-pill d-flex align-items-center gap-2 ps-2 pe-3"
                            data-bs-toggle="dropdown"
                            style="border: 2px solid #e9ecef;">
                        <img class="rounded-circle" 
                             src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('assets/images/lg/avatar4.svg') }}"
                             alt="Profile"
                             style="width: 35px; height: 35px; object-fit: cover;">
                        <div class="text-start d-none d-lg-block">
                            <p class="mb-0 fw-semibold" style="font-size: 0.85rem; line-height: 1.2;">
                                {{ Auth::user()->prenom_utilisateur }}
                            </p>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                {{ Auth::user()->type }}
                            </small>
                        </div>
                        <i class="bi bi-chevron-down text-muted d-none d-lg-block"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 p-0" style="min-width: 280px;">
                        {{-- Header profil --}}
                        <div class="px-3 py-3 bg-gradient bg-primary text-white rounded-top">
                            <div class="d-flex align-items-center">
                                <img class="rounded-circle me-3" 
                                     src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('assets/images/lg/avatar4.svg') }}"
                                     alt="Profile"
                                     style="width: 50px; height: 50px; object-fit: cover; border: 3px solid rgba(255,255,255,0.3);">
                                <div>
                                    <p class="mb-0 fw-bold">
                                        {{ Auth::user()->nom_utilisateur }} {{ Auth::user()->prenom_utilisateur }}
                                    </p>
                                    <small class="opacity-75">{{ Auth::user()->email }}</small>
                                </div>
                            </div>
                        </div>

                        {{-- Menu --}}
                        <div class="py-2">
                            <a href="{{ route('profile') }}" class="dropdown-item py-2 d-flex align-items-center">
                                <i class="bi bi-person-circle text-primary me-3 fs-5"></i>
                                <span>Mon Profil</span>
                            </a>
                            
                            <a href="{{ route('notifications.index') }}" class="dropdown-item py-2 d-flex align-items-center">
                                <i class="bi bi-bell text-primary me-3 fs-5"></i>
                                <span>Notifications</span>
                                @if(auth()->user()->unreadNotifications->count())
                                    <span class="badge bg-danger ms-auto">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </a>
                            
                            <a href="#" data-bs-toggle="modal" data-bs-target="#Settingmodal" class="dropdown-item py-2 d-flex align-items-center">
                                <i class="bi bi-gear text-primary me-3 fs-5"></i>
                                <span>Paramètres</span>
                            </a>

                            <div class="dropdown-divider my-2"></div>

                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="dropdown-item py-2 d-flex align-items-center text-danger">
                                <i class="bi bi-box-arrow-right me-3 fs-5"></i>
                                <span>Déconnexion</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Menu mobile toggle --}}
                <button class="btn btn-light rounded-circle d-md-none d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px;"
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#mainHeader">
                    <i class="bi bi-three-dots-vertical text-primary fs-5"></i>
                </button>

            </div>

            {{-- Formulaire de déconnexion caché --}}
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

        </div>
    </nav>
</div>

<style>
/* Navbar moderne sobre */
.header {
    background: white;
    border-bottom: 1px solid #e9ecef;
    box-shadow: 0 2px 4px rgba(0,0,0,0.04);
}

.navbar {
    padding: 0.75rem 0;
}

/* Boutons arrondis cohérents */
.btn-light {
    background: #f8f9fa;
    border: none;
    transition: all 0.3s ease;
}

.btn-light:hover {
    background: #e9ecef;
    transform: translateY(-2px);
}

/* Barre de recherche */
.search-box input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.1);
    background: white;
}

/* Dropdown moderne */
.dropdown-menu {
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Hover sur les items de notification */
.hover-bg-light:hover {
    background: #f8f9fa;
}

/* Badge pulse animation */
.badge {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.8;
    }
}

/* Scrollbar personnalisée pour notifications */
.notification-list::-webkit-scrollbar {
    width: 5px;
}

.notification-list::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.notification-list::-webkit-scrollbar-thumb {
    background: #667eea;
    border-radius: 10px;
}

/* Responsive */
@media (max-width: 768px) {
    .search-box {
        display: none;
    }
}
</style>

<script>
// Initialiser les tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>