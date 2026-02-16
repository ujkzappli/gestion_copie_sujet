{{-- Sidebar pour Enseignant --}}

<li class="sidebar-title">Mes Activités</li>

<li>
    <a class="m-link {{ request()->routeIs('lot-copies.*') ? 'active' : '' }}"
       href="{{ route('lot-copies.index') }}">
        <i class="bi bi-archive-fill fs-5"></i>
        <span>Lots de Copies</span>
    </a>
</li>

<li>
    <a class="m-link {{ request()->routeIs('modules.*') ? 'active' : '' }}"
       href="{{ route('modules.index') }}">
        <i class="icofont-book-alt fs-5"></i>
        <span>Mes Modules</span>
    </a>
</li>