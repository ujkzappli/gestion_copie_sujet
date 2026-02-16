{{-- Sidebar pour President --}}

<li class="sidebar-title">Gestion</li>

<li>
    <a class="m-link {{ request()->routeIs('lot-copies.*') ? 'active' : '' }}"
       href="{{ route('lot-copies.index') }}">
        <i class="bi bi-archive-fill fs-5"></i>
        <span>Lots de Copies</span>
    </a>
</li>