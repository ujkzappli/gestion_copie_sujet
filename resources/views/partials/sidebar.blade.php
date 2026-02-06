<div class="sidebar px-4 py-4 py-md-4 me-0">
    <div class="d-flex flex-column h-100">

        <!-- LOGO -->
        <a href="{{ route('dashboard') }}" class="mb-0 brand-icon">
            <span class="logo-icon">
                <i class="bi bi-bag-check-fill fs-4"></i>
            </span>
            <span class="logo-text">Gestion Copies</span>
        </a>

        <!-- MENU -->
        <ul class="menu-list flex-grow-1 mt-3">

            <!-- DASHBOARD -->
            <li>
                <a class="m-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   href="{{ route('dashboard') }}">
                    <i class="icofont-home fs-5"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a class="m-link {{ request()->routeIs('lot-copies.*') ? 'active' : '' }}"
                href="{{ route('lot-copies.index') }}">
                    <i class="fas fa-copy fs-5"></i> <!-- Icône "copie" -->
                    <span>Lot Copies</span>
                </a>
            </li>
            
            <li>
                <a class="m-link {{ request()->routeIs('etablissements.*') ? 'active' : '' }}"
                href="{{ route('etablissements.index') }}">
                    <i class="icofont-building fs-5"></i>
                    <span>Établissements</span>
                </a>
            </li>

            <li>
                <a class="m-link {{ request()->routeIs('departements.*') ? 'active' : '' }}"
                href="{{ route('departements.index') }}">
                    <i class="icofont-ui-office fs-5"></i>
                    <span>Départements</span>
                </a>
            </li>

            <li>
                <a class="m-link {{ request()->routeIs('options.*') ? 'active' : '' }}"
                href="{{ route('options.index') }}">
                    <i class="icofont-ui-settings fs-5"></i>
                    <span>Options</span>
                </a>
            </li>

            <li>
                <a class="m-link {{ request()->routeIs('session_examens.*') ? 'active' : '' }}"
                href="{{ route('session_examens.index') }}">
                    <i class="icofont-calendar fs-5"></i>
                    <span>Sessions d’examen</span>
                </a>
            </li>

            <li>
                <a class="m-link {{ request()->routeIs('semestres.*') ? 'active' : '' }}"
                href="{{ route('semestres.index') }}">
                    <i class="icofont-clock-time fs-5"></i>
                    <span>Semestres</span>
                </a>
            </li>

            <li>
                <a class="m-link {{ request()->routeIs('modules.*') ? 'active' : '' }}"
                href="{{ route('modules.index') }}">
                    <i class="icofont-book-alt fs-5"></i>
                    <span>Modules</span>
                </a>
            </li>
            <li>
                <a class="m-link {{ request()->is('admin/users/create') ? 'active' : '' }}"
                href="{{ url('/admin/users/create') }}">
                    <i class="icofont-user-plus fs-5"></i>
                    <span>Créer un utilisateur</span>
                </a>
            </li>
            <li>
                <a class="m-link {{ request()->routeIs('profile') ? 'active' : '' }}"
                   href="{{ route('profile') }}">
                    <i class="icofont-user fs-5"></i>
                    <span>Mon Profil</span>
                </a>
            </li>

        </ul>

        <!-- BOUTON REDUCTION -->
        <button type="button" class="btn btn-link sidebar-mini-btn text-light">
            <span class="ms-2">
                <i class="icofont-bubble-right"></i>
            </span>
        </button>

    </div>
</div>
