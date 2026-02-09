<div class="sidebar px-4 py-4 py-md-4 me-0">
    <div class="d-flex flex-column h-100">

        <!-- LOGO COMMUN -->
        <a href="{{ route('dashboard') }}" class="mb-0 brand-icon">
            <span class="logo-icon">
                <img src="{{ asset('assets/images/image.png') }}" alt="Logo" style="height: 40px;">
            </span>
            <span class="logo-text">Gestion Copies</span>
        </a>


        <!-- MENU COMMUN -->
        <ul class="menu-list flex-grow-1 mt-3">
            <li>
                <a class="m-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   href="{{ route('dashboard') }}">
                    <i class="icofont-home fs-5"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- MENU SPÉCIFIQUE AU RÔLE -->
            @php
                $user = auth()->user();
            @endphp

            @if($user->isAdmin())
                @include('partials.sidebars.admin')
            @elseif($user->isPresident())
                @include('partials.sidebars.president')
            @elseif($user->isEnseignant())
                @include('partials.sidebars.enseignant')
            @elseif($user->isCD())
                @include('partials.sidebars.cd')
            @elseif($user->isCS())
                @include('partials.sidebars.cs')
            @elseif($user->isDA())
                @include('partials.sidebars.da')
            @endif
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
