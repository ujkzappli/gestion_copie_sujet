<ul class="menu-list flex-grow-1 mt-3">

    {{-- Gestion des copies --}}
    <li>
        <a class="m-link {{ request()->routeIs('lot-copies.*') ? 'active' : '' }}"
           href="{{ route('lot-copies.index') }}">
            <i class="fas fa-copy fs-5"></i>
            <span>Lot Copies</span>
        </a>
    </li>

    {{-- Établissements et Départements --}}
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

    {{-- Sessions d’examen & Semestres --}}
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

    {{-- Modules --}}
    <li>
        <a class="m-link {{ request()->routeIs('modules.*') ? 'active' : '' }}"
           href="{{ route('modules.index') }}">
            <i class="icofont-book-alt fs-5"></i>
            <span>Modules</span>
        </a>
    </li>

    {{-- Admin spécifique : création d’utilisateurs --}}
    <li>
        <a class="m-link {{ request()->is('admin/users/create') ? 'active' : '' }}"
           href="{{ url('/admin/users/create') }}">
            <i class="icofont-user-plus fs-5"></i>
            <span>Créer un utilisateur</span>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('system.scan') }}" class="nav-link btn btn-warning text-white mb-2">
            <i class="bi bi-search"></i> Lancer le scan des retards
        </a>
    </li>

</ul>
