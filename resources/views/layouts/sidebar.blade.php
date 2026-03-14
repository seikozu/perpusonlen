<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <img src="{{ Auth::user()->id_google ? 'https://lh3.googleusercontent.com/a/' . Auth::user()->id_google : asset('assets/images/faces/face1.jpg') }}" alt="profile" />
          <span class="login-status online"></span>
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
          <span class="text-secondary text-small">Administrator</span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/dashboard') }}">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/kategori') }}">
        <span class="menu-title">Kelola Kategori</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/buku') }}">
        <span class="menu-title">Kelola Buku</span>
        <i class="mdi mdi-book-open-variant menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/halaman-pdf') }}">
        <span class="menu-title">Cetak PDF</span>
        <i class="mdi mdi-file-pdf menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('barang.index') }}">
        <span class="menu-title">Kelola Barang</span>
        <i class="mdi mdi-cube menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-modul4" aria-expanded="false" aria-controls="ui-modul4">
        <span class="menu-title">Tugas Modul 4</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-modul4">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> 
            <a class="nav-link" href="{{ url('/modul4/tabel-biasa') }}">Tabel Biasa</a>
          </li>
          <li class="nav-item"> 
            <a class="nav-link" href="{{ url('/modul4/tabel-datatables') }}">DataTables</a>
          </li>
          <li class="nav-item"> 
              <a class="nav-link" href="{{ url('/modul4/select-kota') }}"> Manipulasi Select </a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/modul5/wilayah') }}">
        <span class="menu-title">Kelola Wilayah</span>
        <i class="mdi mdi-map-marker menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/modul5/pos') }}">
        <span class="menu-title">Transaksi Penjualan</span>
        <i class="mdi mdi-cart menu-icon"></i>
      </a>
  </ul> 
</nav>