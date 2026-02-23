@extends('layouts.main')

@section('title', 'Dashboard - Admin')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Dashboard </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <span></span>Dashboard <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
            </li>
        </ul>
    </nav>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center py-5">
                <h1 class="display-4 font-weight-bold">Halo Admin</h1>
                 <p class="lead text-muted">Jangan lupa makan karena gak semua punya someone buat diajak makan siang.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Total Pengguna <i class="mdi mdi-account-multiple mdi-24px float-end"></i></h4>
                <h2 class="mb-5">2</h2>
                <h6 class="card-text">Terdaftar dalam sistem</h6>
            </div>
        </div>
    </div>

    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Total Kategori <i class="mdi mdi-format-list-bulleted mdi-24px float-end"></i></h4>
                <h2 class="mb-5">4</h2>
                <h6 class="card-text">Novel, Biografi, Komik, dll.</h6>
            </div>
        </div>
    </div>

    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Total Buku <i class="mdi mdi-book-open-variant mdi-24px float-end"></i></h4>
                <h2 class="mb-5">3</h2>
                <h6 class="card-text">Koleksi buku tersedia</h6>
            </div>
        </div>
    </div>
</div>
@endsection