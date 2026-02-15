<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        {{-- PROFILE --}}
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ asset('assets/images/faces/face1.jpg') }}">
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">Admin</span>
                    <span class="text-secondary text-small">User</span>
                </div>
            </a>
        </li>

        {{-- TITLE --}}
        <li class="nav-item nav-category">
            <span class="nav-link">ADMIN MENU</span>
        </li>

        {{-- DASHBOARD --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                <i class="mdi mdi-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        {{-- KATEGORI --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                <span class="menu-title">Kelola Kategori</span>
            </a>
        </li>

        {{-- BUKU --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('buku.*') ? 'active' : '' }}" href="{{ route('buku.index') }}">
                <i class="mdi mdi-book menu-icon"></i>
                <span class="menu-title">Kelola Buku</span>
            </a>
        </li>

    </ul>
</nav>
