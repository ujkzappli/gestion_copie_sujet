<ul class="menu-list flex-grow-1 mt-3">

    {{-- Gestion des copies --}}
    <li>
        <a class="m-link {{ request()->routeIs('lot-copies.*') ? 'active' : '' }}"
           href="{{ route('lot-copies.index') }}">
            <i class="fas fa-copy fs-5"></i>
            <span>Lot Copies</span>
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

</ul>
