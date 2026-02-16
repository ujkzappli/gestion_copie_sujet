{{-- Sidebar pour Administrateur --}}

<li class="sidebar-title">Gestion des Copies</li>

<li>
    <a class="m-link {{ request()->routeIs('lot-copies.*') ? 'active' : '' }}"
       href="{{ route('lot-copies.index') }}">
        <i class="bi bi-archive-fill fs-5"></i>
        <span>Lots de Copies</span>
    </a>
</li>

<li class="sidebar-title">Structure</li>

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
        <span>Parcours</span>
    </a>
</li>

<li class="sidebar-title">Configuration Académique</li>

<li>
    <a class="m-link {{ request()->routeIs('session_examens.*') ? 'active' : '' }}"
       href="{{ route('session_examens.index') }}">
        <i class="icofont-calendar fs-5"></i>
        <span>Sessions d'Examen</span>
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

<li class="sidebar-title">Administration</li>

<li>
    <a class="m-link {{ request()->is('admin/users*') ? 'active' : '' }}"
       href="{{ url('/admin/users') }}">
        <i class="bi bi-people-fill fs-5"></i>
        <span>Utilisateurs</span>
    </a>
</li>

<li class="sidebar-title">Système</li>

<li>
    <a class="m-link {{ request()->routeIs('system.scan') ? 'active' : '' }}"
       href="{{ route('system.scan') }}">
        <i class="icofont-search-2 fs-5"></i>
        <span>Scanner Retards</span>
    </a>
</li>