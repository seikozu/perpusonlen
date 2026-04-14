<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <a class="navbar-brand brand-logo" href="{{ url('/dashboard') }}"><img src="{{ asset('assets/images/logo.svg') }}" alt="logo" /></a>
    <a class="navbar-brand brand-logo-mini" href="{{ url('/dashboard') }}"><img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo" /></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-stretch">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>
    <div class="search-field d-none d-md-block">
      <form class="d-flex align-items-center h-100" action="#">
        <div class="input-group">
          <div class="input-group-prepend bg-transparent">
            <i class="input-group-text border-0 mdi mdi-magnify"></i>
          </div>
          <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
        </div>
      </form>
    </div>
    <ul class="navbar-nav navbar-nav-right">
      
      {{-- MODIFIKASI DI SINI: Cek apakah User Login atau Guest --}}
      @auth
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="nav-profile-img">
            {{-- Tambahkan pengecekan optional() agar id_google tidak crash --}}
            <img src="{{ Auth::user()->id_google ? 'https://lh3.googleusercontent.com/a/' . Auth::user()->id_google : asset('assets/images/faces/face1.jpg') }}" alt="image">
            <span class="availability-status online"></span>
          </div>
          <div class="nav-profile-text">
            <p class="mb-1 text-black">{{ Auth::user()->name }}</p>
          </div>
        </a>
        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="#">
            <i class="mdi mdi-cached me-2 text-success"></i> Activity Log </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('logout') }}" 
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="mdi mdi-logout me-2 text-primary"></i> Signout 
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
        </div>
      </li>
      @else
      {{-- Tampilan untuk Guest / Tamu --}}
      <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">
          <button class="btn btn-sm btn-gradient-primary">Login</button>
        </a>
      </li>
      @endauth

      <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="mdi mdi-email-outline"></i>
          <span class="count-symbol bg-warning"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="messageDropdown">
          <h6 class="p-3 mb-0">Messages</h6>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
              <h6 class="preview-subject ellipsis mb-1 font-weight-normal">No new messages</h6>
            </div>
          </a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
          <i class="mdi mdi-bell-outline"></i>
          <span class="count-symbol bg-danger"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
          <h6 class="p-3 mb-0">Notifications</h6>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
              <h6 class="preview-subject font-weight-normal mb-1">No new notifications</h6>
            </div>
          </a>
        </div>
      </li>

      <li class="nav-item d-none d-lg-block full-screen-link">
        <a class="nav-link">
          <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
        </a>
      </li>

      <li class="nav-item nav-logout d-none d-lg-block">
        {{-- Logout button juga dibungkus @auth agar tidak muncul bagi Guest --}}
        @auth
        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="mdi mdi-power"></i>
        </a>
        @endauth
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>