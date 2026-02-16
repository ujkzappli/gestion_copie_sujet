{{-- Sidebar pour Directeur Académique (DA) --}}

<li class="sidebar-title">Gestion des Copies</li>

<li>
    <a class="m-link {{ request()->routeIs('lot-copies.*') ? 'active' : '' }}"
       href="{{ route('lot-copies.index') }}">
        <i class="bi bi-archive-fill fs-5"></i>
        <span>Lots de Copies</span>
    </a>
</li>

<li class="sidebar-title">Configuration</li>

<li>
    <a class="m-link {{ request()->routeIs('options.*') ? 'active' : '' }}"
       href="{{ route('options.index') }}">
        <i class="icofont-ui-settings fs-5"></i>
        <span>Parcours</span>
    </a>
</li>

<li>
    <a class="m-link {{ request()->routeIs('modules.*') ? 'active' : '' }}"
       href="{{ route('modules.index') }}">
        <i class="icofont-book-alt fs-5"></i>
        <span>Modules</span>
    </a>
</li>