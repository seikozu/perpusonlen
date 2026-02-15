@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Dashboard
    </h3>
</div>

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Welcome, {{ Auth::user()->name }}!</h4>
                <p class="card-description">
                    You have successfully logged in.
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Card Jumlah Kategori -->
    <div class="col-md-6 stretch-card grid-margin">
        <div class="card bg-gradient-primary text-white">
            <div class="card-body">
                <h4>Total Kategori</h4>
                <h2>{{ $jumlahKategori }}</h2>
            </div>
        </div>
    </div>

    <!-- Card Jumlah Buku -->
    <div class="col-md-6 stretch-card grid-margin">
        <div class="card bg-gradient-success text-white">
            <div class="card-body">
                <h4>Total Buku</h4>
                <h2>{{ $jumlahBuku }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection
