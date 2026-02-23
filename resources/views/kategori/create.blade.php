@extends('layouts.main')

@section('title', 'Tambah Kategori')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Form Tambah Kategori </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/kategori') }}">Kategori</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Input Kategori Baru</h4>
                <p class="card-description"> Tambahkan kategori buku seperti Novel, Komik, dll. </p>
                
                <form class="forms-sample" action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Contoh: Novel / Biografi" required>
                    </div>
                    
                    <button type="submit" class="btn btn-gradient-primary me-2">Simpan</button>
                    <a href="{{ url('/kategori') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection